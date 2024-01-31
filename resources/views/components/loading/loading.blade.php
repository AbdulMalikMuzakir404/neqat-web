<style>
    @import url(https://fonts.googleapis.com/css?family=Montserrat:400,700);

    /* body {
        margin: 0;
        overflow: hidden;
    } */

    #loading-overlay {
        width: 100%;
        height: 100%;
        background-color: #68C3A3;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-panel-wrap {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .loading-panel {
        display: table;
        width: 200px;
        height: 80px;
        padding: 0px 30px;

        background-color: #ddd;
        border-radius: 10px;
        -webkit-box-shadow: inset 0px 2px 0px 0px rgba(238, 238, 238, 1), 0px 1px 1px rgba(0, 0, 0, 0.4);
        -moz-box-shadow: inset 0px 2px 0px 0px rgba(238, 238, 238, 1), 0px 1px 1px rgba(0, 0, 0, 0.4);
        box-shadow: inset 0px 2px 0px 0px rgba(238, 238, 238, 1), 0px 1px 1px rgba(0, 0, 0, 0.4);

        animation: 2s bounce ease infinite;

    }

    .loading-panel span {
        display: table-cell;
        vertical-align: middle;
    }

    .loading-panel h3 {
        color: #666;
        text-align: center;
        text-transform: uppercase;
        font-family: 'Montserrat';
        font-weight: bold;
    }

    .shadow {
        position: absolute;
        width: 175px;
        height: 20px;
        bottom: -15%;
        left: 50%;
        transform: translateX(-50%);

        border-radius: 50%;
        background-color: #464646;
        opacity: 0.2;

        transform-origin: -50% -50%;
        animation: 2s pulsate ease infinite;

        z-index: -1;
    }

    @keyframes bounce {
        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes pulsate {
        0% {
            opacity: 0;
        }

        50% {
            transform: scale(0.5);
            opacity: 0.2;
        }

        100% {
            opacity: 0;
        }
    }
</style>

<div class="loading-panel-wrap" id="loading-overlay">
    <div class="loading-panel">
        <span>
            <h3>Loading</h3>
        </span>
    </div>
    <div class="shadow"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Show loading overlay when page is loading
        document.getElementById("loading-overlay").style.display = "flex";

        // Disable the #app element
        document.getElementById("app").style.pointerEvents = "none";

        // Hide loading overlay and enable the #app element when the page has finished loading
        window.addEventListener("load", function() {
            document.getElementById("loading-overlay").style.display = "none";
            document.getElementById("app").style.display = "block";
            document.getElementById("app").style.pointerEvents = "auto";
        });
    });
</script>
