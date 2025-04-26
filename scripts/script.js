document.addEventListener("DOMContentLoaded", () => {
    const rowsPerPage = 5;
    const tableRows = document.querySelectorAll(".user-row");
    const totalPages = Math.ceil(tableRows.length / rowsPerPage);

    const pagination = document.querySelector(".pagination");
    const prevBtn = pagination.querySelector(".prev-btn");
    const nextBtn = pagination.querySelector(".next-btn");

    let currentPage = 1;
    let paginationButtons = [];

    if (totalPages === 0) {
      prevBtn.style.display = "none";
      nextBtn.style.display = "none";
      return; // No need to proceed further
    }


    function createPaginationButtons() {
      // Remove existing number buttons if any
      paginationButtons.forEach(btn => btn.remove());
      paginationButtons = [];

      for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        btn.className = "rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold page-btn";

        // Insert the button before the "next" button
        pagination.insertBefore(btn, nextBtn);

        // Add click event
        btn.addEventListener("click", () => {
          currentPage = i;
          showPage(currentPage);
        });

        paginationButtons.push(btn);
      }
    }

    function showPage(page) {
      const start = (page - 1) * rowsPerPage;
      const end = start + rowsPerPage;

      tableRows.forEach((row, index) => {
        row.style.display = index >= start && index < end ? "" : "none";
      });

      paginationButtons.forEach((btn, i) => {
        if ((i + 1) === page) {
          btn.classList.add("bg-amber-400", "text-white");
          btn.classList.remove("hover:bg-yellow-100");
        } else {
          btn.classList.remove("bg-amber-400", "text-white");
          btn.classList.add("hover:bg-yellow-100");
        }
      });
    }

    prevBtn.addEventListener("click", () => {
      if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
      }
    });

    nextBtn.addEventListener("click", () => {
      if (currentPage < totalPages) {
        currentPage++;
        showPage(currentPage);
      }
    });

    createPaginationButtons(); // Build buttons dynamically
    showPage(currentPage);     // Show initial page
  });