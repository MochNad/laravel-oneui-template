!(function () {
    "use strict";

    class Mode {
        static initMode() {
            let currentMode = $.cookie("mode");
            if (currentMode === undefined) {
                currentMode = getMedia();
                $.cookie("mode", currentMode, { path: "/" });
            }

            $('[data-action="dark_mode_toggle"]').each(function () {
                const toggleButton = $(this);
                toggleButton.on("click", function () {
                    currentMode = currentMode === "dark" ? "light" : "dark";
                    $.cookie("mode", currentMode, { path: "/" });
                });
            });

            function getMedia() {
                return window.matchMedia("(prefers-color-scheme: dark)").matches
                    ? "dark"
                    : "light";
            }
        }

        static init() {
            this.initMode();
        }
    }

    One.onLoad(() => Mode.init());
})();
