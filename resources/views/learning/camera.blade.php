@extends('layouts.app')

@section('title', 'Camera lab')

@section('content')
<div class="app-container module-page">
    <header class="page-heading"><div><p class="eyebrow">Touchless interaction study</p><h1>Camera lab</h1><p class="page-subtitle">A permission-first preview for the proposed on-device gesture interaction.</p></div><span class="badge bg-warning">Prototype</span></header>
    <div class="camera-layout">
        <section class="surface"><div class="surface-heading"><h2>Local camera preview</h2><span class="camera-status" id="camera-status" aria-live="polite">Camera is off</span></div><div class="camera-preview"><video id="camera-video" autoplay muted playsinline hidden></video><div class="camera-placeholder" id="camera-placeholder"><i class="fas fa-camera" aria-hidden="true"></i><span>Your camera stays off until you choose to start it.</span></div></div><div class="surface-body d-flex flex-wrap gap-2"><button type="button" class="btn btn-primary" id="camera-start"><i class="fas fa-video me-2" aria-hidden="true"></i>Start camera</button><button type="button" class="btn btn-outline-dark" id="camera-stop" disabled><i class="fas fa-video-slash me-2" aria-hidden="true"></i>Stop camera</button></div></section>
        <aside class="surface"><div class="surface-heading"><h2>Study status</h2></div><div class="surface-body"><p>This prototype requests a camera stream only after you press <strong>Start camera</strong>. The stream is previewed in this browser tab and stopped when you leave the page.</p><p class="study-note">Hand-landmark inference, gesture classification, and gesture-to-route events from the proposal are not connected in this Laravel build yet. No gesture is detected or sent to a server.</p><h3 class="h6 mt-4">Proposed gesture map</h3><ul class="small text-secondary"><li>1–4 fingers: open learning sections</li><li>Open palm: focus dictionary search</li><li>Fist: open the camera dashboard</li><li>Horizontal swipe: move between sections</li></ul></div></aside>
    </div>
</div>
@endsection