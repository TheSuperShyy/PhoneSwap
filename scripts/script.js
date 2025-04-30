document.addEventListener("DOMContentLoaded", () => {
  const rowsPerPage = 5;
  const tableRows = document.querySelectorAll(".user-row");
  const totalPages = Math.ceil(tableRows.length / rowsPerPage);

  const pagination = document.querySelector(".pagination");
  const prevBtn = pagination.querySelector(".prev-btn");
  const nextBtn = pagination.querySelector(".next-btn");

  let currentPage = 1;

  if (totalPages === 0) {
    prevBtn.style.display = "none";
    nextBtn.style.display = "none";
    return; // No need to proceed further
  }

  function showPage(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    tableRows.forEach((row, index) => {
      row.style.display = index >= start && index < end ? "" : "none";
    });

    currentPage = page;
    createPaginationButtons();
  }

  function createPaginationButtons() {
    // Remove existing page buttons and dots
    const oldButtons = pagination.querySelectorAll(".page-btn, .dots");
    oldButtons.forEach(btn => btn.remove());
    
    const maxVisibleButtons = 3;
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    if (currentPage <= 3) {
      startPage = 1;
      endPage = Math.min(totalPages, maxVisibleButtons);
    } else if (currentPage >= totalPages - 2) {
      endPage = totalPages;
      startPage = Math.max(1, totalPages - maxVisibleButtons + 1);
    }

    if (startPage > 1) {
      addPageButton(1);
      if (startPage > 2) addDots();
    }

    for (let i = startPage; i <= endPage; i++) {
      addPageButton(i);
    }

    if (endPage < totalPages) {
      if (endPage < totalPages - 1) addDots();
      addPageButton(totalPages);
    }
  }

  function addPageButton(page) {
    const btn = document.createElement("button");
    btn.textContent = page;
    btn.className = "rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold page-btn";
    if (page === currentPage) {
      btn.classList.add("bg-amber-400", "text-white");
    }
    btn.addEventListener("click", () => {
      showPage(page);
    });
    pagination.insertBefore(btn, nextBtn);
  }

  function addDots() {
    const dots = document.createElement("span");
    dots.textContent = "...";
    dots.className = "dots px-2";
    pagination.insertBefore(dots, nextBtn);
  }

  prevBtn.addEventListener("click", () => {
    if (currentPage > 1) {
      showPage(currentPage - 1);
    }
  });

  nextBtn.addEventListener("click", () => {
    if (currentPage < totalPages) {
      showPage(currentPage + 1);
    }
  });

  showPage(currentPage); // Initialize
});