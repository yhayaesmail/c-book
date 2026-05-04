const BASE_URL = window.BASE_URL || "/chat-book";

function showToast(message) {
  const toast = document.getElementById("toast");
  if (!toast) return;
  toast.textContent = message;
  toast.classList.add("show");
  clearTimeout(window.__toastTimer);
  window.__toastTimer = setTimeout(() => toast.classList.remove("show"), 3000);
}

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const suggestionsBox = document.getElementById("suggestions");
  const cartCount = document.getElementById("cartCount");
  const menuToggle = document.getElementById("menuToggle");
  const navLinks = document.getElementById("navLinks");

  if (menuToggle && navLinks) {
    menuToggle.addEventListener("click", () => navLinks.classList.toggle("open"));
  }

  if (searchInput && suggestionsBox) {
    let controller;
    searchInput.addEventListener("input", function () {
      const term = this.value.trim();
      if (controller) controller.abort();
      if (term.length < 2) {
        suggestionsBox.innerHTML = "";
        suggestionsBox.style.display = "none";
        return;
      }
      controller = new AbortController();
      fetch(BASE_URL + "/books/suggestions?term=" + encodeURIComponent(term), { signal: controller.signal })
        .then((res) => res.ok ? res.json() : [])
        .then((data) => {
          suggestionsBox.innerHTML = "";
          data.forEach((item) => {
            const div = document.createElement("div");
            div.textContent = item.title + " by " + item.author;
            div.addEventListener("click", () => {
              window.location.href = BASE_URL + "/books/details/" + item.id;
            });
            suggestionsBox.appendChild(div);
          });
          suggestionsBox.style.display = data.length ? "block" : "none";
        })
        .catch(() => {});
    });

    document.addEventListener("click", function (e) {
      if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
        suggestionsBox.style.display = "none";
      }
    });
  }

  if (cartCount) {
    fetch(BASE_URL + "/cart/count")
      .then((res) => res.json())
      .then((data) => {
        cartCount.textContent = data.count || 0;
      })
      .catch(() => {
        cartCount.textContent = "0";
      });
  }

  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".add-to-cart");
    if (!btn) return;
    e.preventDefault();
    const href = btn.getAttribute("href");
    if (!href) return;
    btn.classList.add("loading");
    fetch(href, { headers: { "X-Requested-With": "XMLHttpRequest" } })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          if (cartCount) cartCount.textContent = data.count;
          showToast("Book added to cart!");
        } else {
          showToast(data.message || "Please login first");
          if (data.message) setTimeout(() => window.location.href = BASE_URL + "/auth/login", 800);
        }
      })
      .catch(() => showToast("Something went wrong"))
      .finally(() => btn.classList.remove("loading"));
  });
});
