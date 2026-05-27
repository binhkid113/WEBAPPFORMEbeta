(function () {
  const storedTheme = localStorage.getItem("otoku-theme") || "dark";
  document.body.classList.toggle("light", storedTheme === "light");

  document.addEventListener("click", function (event) {
    const button = event.target.closest("[data-action='toggle-theme']");
    if (!button) {
      return;
    }

    const isLight = document.body.classList.toggle("light");
    localStorage.setItem("otoku-theme", isLight ? "light" : "dark");
  });

  if (window.lucide) {
    window.lucide.createIcons();
  }
})();
