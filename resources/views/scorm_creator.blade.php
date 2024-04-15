<div id="creator-container" style="height:95vh"></div>

<script type="module">
    import RefreshRuntime from 'http://localhost:80/@react-refresh'
    RefreshRuntime.injectIntoGlobalHook(window)
    window.$RefreshReg$ = () => {}
    window.$RefreshSig$ = () => (type) => type
    window.__vite_plugin_react_preamble_installed__ = true
</script>

<script type="module">
    import { initializeCreator } from "{{ Vite::asset('resources/js/Scripts/SCORMCreator.jsx') }}";
    // Ensure that the initializeCreator function is imported successfully
    if (typeof initializeCreator === 'function') {
        console.log("initializeCreator function is imported successfully");
        initializeCreator(); // Initialize creator when the event is triggered
        // Add an event listener for turbo:before-render
    } else {
        console.error("initializeCreator function is not imported correctly");
    }
</script>
