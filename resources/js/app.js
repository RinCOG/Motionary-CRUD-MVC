import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const dictionary = document.querySelector('[data-dictionary-search]');

if (dictionary) {
	const form = document.querySelector('#word-search-form');
	const input = document.querySelector('#word-search');
	const status = document.querySelector('#lookup-status');
	const result = document.querySelector('#word-result');
	const recentList = document.querySelector('#recent-searches');
	const historyKey = 'motionary.recent-searches';
	let activeRequest;

	const dispatch = (name, detail = {}) => window.dispatchEvent(new CustomEvent(`motionary:${name}`, { detail }));

	const readHistory = () => {
		try {
			return JSON.parse(localStorage.getItem(historyKey) || '[]');
		} catch {
			return [];
		}
	};

	const renderHistory = () => {
		const history = readHistory();
		recentList.replaceChildren();

		if (history.length === 0) {
			const empty = document.createElement('li');
			empty.className = 'recent-empty';
			empty.textContent = 'Words you look up will appear here.';
			recentList.append(empty);
			return;
		}

		history.forEach((term) => {
			const item = document.createElement('li');
			const button = document.createElement('button');
			button.type = 'button';
			button.className = 'recent-word';
			button.textContent = term;
			button.addEventListener('click', () => {
				input.value = term;
				form.requestSubmit();
			});
			item.append(button);
			recentList.append(item);
		});
	};

	const makeText = (tag, className, text) => {
		const element = document.createElement(tag);
		if (className) element.className = className;
		element.textContent = text;
		return element;
	};

	const saveHistory = (term) => {
		const history = [term, ...readHistory().filter((item) => item.toLowerCase() !== term.toLowerCase())].slice(0, 6);
		localStorage.setItem(historyKey, JSON.stringify(history));
		renderHistory();
	};

	const renderEntry = (entry) => {
		result.replaceChildren();
		result.hidden = false;

		const top = document.createElement('div');
		top.className = 'result-top';
		const identity = document.createElement('div');
		identity.append(makeText('h2', 'result-word', entry.word || input.value));
		const phonetic = entry.phonetic || entry.phonetics?.find((item) => item.text)?.text || '';
		if (phonetic) identity.append(makeText('p', 'result-phonetic', phonetic));
		top.append(identity);

		const audio = entry.phonetics?.find((item) => item.audio)?.audio;
		const pronounce = document.createElement('button');
		pronounce.type = 'button';
		pronounce.className = 'action-icon pronunciation-button';
		pronounce.title = 'Play pronunciation';
		pronounce.setAttribute('aria-label', `Play pronunciation for ${entry.word}`);
		pronounce.innerHTML = '<i class="fas fa-volume-high" aria-hidden="true"></i>';
		pronounce.addEventListener('click', () => {
			if (audio) {
				new Audio(audio.startsWith('//') ? `https:${audio}` : audio).play();
			} else if ('speechSynthesis' in window) {
				window.speechSynthesis.cancel();
				window.speechSynthesis.speak(new SpeechSynthesisUtterance(entry.word));
			}
		});
		top.append(pronounce);
		result.append(top);

		const meanings = (entry.meanings || []).slice(0, 3);
		meanings.forEach((meaning) => {
			const block = document.createElement('section');
			block.className = 'meaning-block';
			block.append(makeText('p', 'part-of-speech', meaning.partOfSpeech || 'Meaning'));
			(meaning.definitions || []).slice(0, 2).forEach((definition, index) => {
				const row = document.createElement('div');
				row.className = 'definition-row';
				row.append(makeText('span', 'definition-index', `${index + 1}`));
				const copy = document.createElement('div');
				copy.append(makeText('p', 'definition-text', definition.definition || ''));
				if (definition.example) copy.append(makeText('p', 'definition-example', `“${definition.example}”`));
				row.append(copy);
				block.append(row);
			});
			if (meaning.synonyms?.length) {
				const synonyms = document.createElement('p');
				synonyms.className = 'synonym-line';
				synonyms.append(makeText('span', '', 'Similar: '));
				meaning.synonyms.slice(0, 5).forEach((synonym, index) => {
					const link = document.createElement('button');
					link.type = 'button';
					link.className = 'synonym-button';
					link.textContent = synonym;
					link.addEventListener('click', () => {
						input.value = synonym;
						form.requestSubmit();
					});
					synonyms.append(link);
					if (index < Math.min(meaning.synonyms.length, 5) - 1) synonyms.append(document.createTextNode(', '));
				});
				block.append(synonyms);
			}
			result.append(block);
		});

		const saveAction = document.createElement('div');
		saveAction.className = 'save-word-row';
		if (dictionary.dataset.authenticated === 'true') {
			const saveButton = document.createElement('button');
			saveButton.type = 'button';
			saveButton.className = 'btn btn-primary';
			saveButton.innerHTML = '<i class="fas fa-bookmark me-2" aria-hidden="true"></i>Save to my wordbook';
			saveButton.addEventListener('click', async () => {
				saveButton.disabled = true;
				try {
					const firstMeaning = entry.meanings?.[0];
					const firstDefinition = firstMeaning?.definitions?.[0];
					const response = await fetch(dictionary.dataset.wordStoreUrl, {
						method: 'POST',
						headers: {
							'Accept': 'application/json',
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
							'X-Requested-With': 'XMLHttpRequest',
						},
						body: JSON.stringify({
							term: entry.word,
							part_of_speech: firstMeaning?.partOfSpeech || '',
							phonetic: phonetic,
							definition: firstDefinition?.definition || '',
							example: firstDefinition?.example || '',
						}),
					});
					if (!response.ok) throw new Error('Unable to save this word. Please try again.');
					saveButton.textContent = 'Saved to your wordbook';
					dispatch('word:saved', { word: entry.word });
				} catch (error) {
					saveButton.disabled = false;
					status.textContent = error.message;
				}
			});
			saveAction.append(saveButton);
		} else {
			const signIn = document.createElement('a');
			signIn.className = 'btn btn-outline-dark';
			signIn.href = '/login';
			signIn.textContent = 'Sign in to save this word';
			saveAction.append(signIn);
		}
		result.append(saveAction);
	};

	const lookup = async (term) => {
		const word = term.trim();
		if (!word) {
			input.focus();
			return;
		}

		activeRequest?.abort();
		activeRequest = new AbortController();
		result.replaceChildren();
		result.hidden = true;
		status.textContent = `Looking up “${word}”…`;
		dispatch('lookup:start', { word });

		try {
			const response = await fetch(`/dictionary/${encodeURIComponent(word)}`, { signal: activeRequest.signal });
			const payload = await response.json();
			if (!response.ok) throw new Error(payload.message || `No dictionary entry found for “${word}”.`);
			if (activeRequest.signal.aborted) return;
			const entry = Array.isArray(payload) ? payload[0] : payload;
			renderEntry(entry);
			status.textContent = '';
			saveHistory(entry.word || word);
			dispatch('lookup:success', { word: entry.word || word, entry });
		} catch (error) {
			if (error.name === 'AbortError') return;
			status.textContent = error.message.includes('Failed to fetch') ? 'Dictionary service is unavailable. Check your connection and try again.' : error.message;
			dispatch('lookup:error', { word, message: status.textContent });
		}
	};

	form.addEventListener('submit', (event) => {
		event.preventDefault();
		lookup(input.value);
	});

	document.querySelector('#clear-history').addEventListener('click', () => {
		localStorage.removeItem(historyKey);
		renderHistory();
	});

	renderHistory();
	const initialWord = new URLSearchParams(window.location.search).get('word');
	if (initialWord) {
		input.value = initialWord;
		lookup(initialWord);
	}
}

document.querySelectorAll('[data-speak-word]').forEach((button) => {
	button.addEventListener('click', () => {
		if (!('speechSynthesis' in window)) return;
		window.speechSynthesis.cancel();
		window.speechSynthesis.speak(new SpeechSynthesisUtterance(button.dataset.speakWord));
	});
});

const wordle = document.querySelector('[data-wordle]');

if (wordle) {
	const answers = ['vivid', 'lucid', 'nuance', 'dream', 'learn', 'words', 'grace', 'light', 'think', 'sense'];
	const dayNumber = Math.floor(Date.now() / 86400000);
	const answer = answers[dayNumber % answers.length];
	const board = document.querySelector('#wordle-board');
	const form = document.querySelector('#wordle-form');
	const guessInput = document.querySelector('#wordle-guess');
	const message = document.querySelector('#wordle-message');
	let guesses = 0;
	let complete = false;

	const drawBoard = () => {
		board.replaceChildren();
		for (let row = 0; row < 6; row += 1) {
			for (let column = 0; column < 5; column += 1) {
				const tile = document.createElement('div');
				tile.className = 'wordle-tile';
				tile.setAttribute('aria-hidden', 'true');
				board.append(tile);
			}
		}
	};

	const evaluateGuess = (guess) => {
		const marks = Array(5).fill('absent');
		const remaining = {};
		for (let index = 0; index < 5; index += 1) {
			if (guess[index] === answer[index]) {
				marks[index] = 'correct';
			} else {
				remaining[answer[index]] = (remaining[answer[index]] || 0) + 1;
			}
		}
		for (let index = 0; index < 5; index += 1) {
			if (marks[index] === 'correct' || !remaining[guess[index]]) continue;
			marks[index] = 'present';
			remaining[guess[index]] -= 1;
		}
		return marks;
	};

	form.addEventListener('submit', (event) => {
		event.preventDefault();
		const guess = guessInput.value.trim().toLowerCase();
		if (complete || !/^[a-z]{5}$/.test(guess)) return;

		const marks = evaluateGuess(guess);
		const tiles = board.querySelectorAll('.wordle-tile');
		marks.forEach((mark, index) => {
			const tile = tiles[(guesses * 5) + index];
			tile.textContent = guess[index];
			tile.classList.add(mark);
		});
		guesses += 1;
		guessInput.value = '';
		const won = guess === answer;
		complete = won || guesses === 6;
		message.textContent = won ? `Lovely. You found “${answer}” in ${guesses} ${guesses === 1 ? 'guess' : 'guesses'}.` : complete ? `The word was “${answer}”. Try again tomorrow.` : `${6 - guesses} ${6 - guesses === 1 ? 'guess' : 'guesses'} left.`;
		window.dispatchEvent(new CustomEvent('motionary:game:guess', { detail: { guess, marks, guesses } }));
		if (won) window.dispatchEvent(new CustomEvent('motionary:game:win', { detail: { answer, guesses } }));
		guessInput.disabled = complete;
	});

	document.querySelector('#new-word-game').addEventListener('click', () => {
		guesses = 0;
		complete = false;
		guessInput.disabled = false;
		message.textContent = 'Puzzle reset.';
		drawBoard();
		guessInput.focus();
	});

	drawBoard();
}

const video = document.querySelector('#camera-video');

if (video) {
	const startButton = document.querySelector('#camera-start');
	const stopButton = document.querySelector('#camera-stop');
	const status = document.querySelector('#camera-status');
	const placeholder = document.querySelector('#camera-placeholder');
	let stream;
	let requestNumber = 0;
	let previewTimeout;

	const stopCamera = () => {
		window.clearTimeout(previewTimeout);
		stream?.getTracks().forEach((track) => track.stop());
		stream = undefined;
		video.srcObject = null;
		video.hidden = true;
		placeholder.hidden = false;
		startButton.disabled = false;
		stopButton.disabled = true;
		status.textContent = 'Camera is off';
		window.dispatchEvent(new CustomEvent('motionary:camera:stopped'));
	};

	startButton.addEventListener('click', async () => {
		if (!navigator.mediaDevices?.getUserMedia) {
			status.textContent = 'Camera access needs a supported browser and a secure connection.';
			return;
		}

		const currentRequest = ++requestNumber;
		startButton.disabled = true;
		status.textContent = 'Waiting for camera permission…';
		let timeoutId;
		let cameraRequest;

		try {
			if (navigator.permissions?.query) {
				const permission = await navigator.permissions.query({ name: 'camera' }).catch(() => null);
				if (permission?.state === 'denied') {
					status.textContent = 'Camera access is blocked. Allow Camera for this site in your browser settings, then try again.';
					startButton.disabled = false;
					return;
				}
			}

			cameraRequest = navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' }, audio: false });
			cameraRequest.then((lateStream) => {
				if (currentRequest !== requestNumber || !startButton.disabled) {
					lateStream.getTracks().forEach((track) => track.stop());
				}
			}).catch(() => {});

			stream = await Promise.race([
				cameraRequest,
				new Promise((_, reject) => {
					timeoutId = window.setTimeout(() => reject(new Error('Camera permission timed out. Check your browser prompt and device connection.')), 12000);
				}),
			]);
			if (currentRequest !== requestNumber) {
				stream.getTracks().forEach((track) => track.stop());
				return;
			}
			video.srcObject = stream;
			video.hidden = false;
			placeholder.hidden = true;
			stopButton.disabled = false;
			status.textContent = 'Camera connected; starting preview…';
			window.dispatchEvent(new CustomEvent('motionary:camera:started'));

			const markPreviewActive = () => {
				window.clearTimeout(previewTimeout);
				if (currentRequest === requestNumber) {
					status.textContent = 'Camera preview is active in this browser';
				}
			};
			video.addEventListener('playing', markPreviewActive, { once: true });
			Promise.resolve(video.play()).then(markPreviewActive).catch(() => {
				window.clearTimeout(previewTimeout);
				if (currentRequest === requestNumber) {
					status.textContent = 'Camera connected, but the video preview could not play. Stop and try again.';
				}
			});
			previewTimeout = window.setTimeout(() => {
				if (currentRequest === requestNumber && video.readyState < HTMLMediaElement.HAVE_CURRENT_DATA) {
					status.textContent = 'Camera is connected, but no video frames are arriving. Check that another app is not using it.';
				}
			}, 5000);
		} catch (error) {
			if (stream) {
				stream.getTracks().forEach((track) => track.stop());
				stream = undefined;
			}
			video.srcObject = null;
			video.hidden = true;
			placeholder.hidden = false;
			startButton.disabled = false;
			status.textContent = error.name === 'NotAllowedError'
				? 'Camera permission was declined. Allow Camera for this site in your browser settings, then try again.'
				: error.name === 'NotFoundError'
					? 'No camera was found. Connect a camera and try again.'
					: error.name === 'NotReadableError' || error.message?.includes('video source')
						? 'The camera could not start. Close other apps using it, then try again.'
						: error.name === 'OverconstrainedError'
							? 'The requested camera mode is unavailable. Try another camera.'
							: error.message || 'The camera could not be started on this device.';
			window.dispatchEvent(new CustomEvent('motionary:camera:error', { detail: { name: error.name } }));
		} finally {
			window.clearTimeout(timeoutId);
		}
	});

	stopButton.addEventListener('click', () => {
		requestNumber += 1;
		stopCamera();
	});
	window.addEventListener('pagehide', () => {
		requestNumber += 1;
		stopCamera();
	}, { once: true });
}
