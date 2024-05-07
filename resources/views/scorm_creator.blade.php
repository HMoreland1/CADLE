<div id="creator-container" style="height:95vh"></div>

<script type="module">
    import RefreshRuntime from 'http://localhost:80/@react-refresh'
    RefreshRuntime.injectIntoGlobalHook(window)
    window.$RefreshReg$ = () => {}
    window.$RefreshSig$ = () => (type) => type
    window.__vite_plugin_react_preamble_installed__ = true
</script>

<script type="module">
    import {initializeCreator} from "{{ Vite::asset('resources/js/Scripts/SCORMCreator.jsx') }}";
    console.log("test");
    const baseContent = {!! json_encode($content->content) !!};
    initializeCreator(baseContent);



</script>

