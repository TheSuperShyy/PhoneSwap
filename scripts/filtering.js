
document.addEventListener('DOMContentLoaded', function () {
  const filterSelect = document.getElementById('filterSelect');
  const searchInput = document.getElementById('searchInput');
  let tableRows = document.querySelectorAll('.user-row');

  function filterTable() {
    const filterBy = filterSelect.value;
    const searchValue = searchInput.value.trim().toLowerCase();

    tableRows.forEach(row => {
      let textToSearch = "";

      switch (filterBy) {
        case "model":
          textToSearch = row.children[3]?.textContent.toLowerCase();
          break;
        case "serial_number":
          textToSearch = row.children[2]?.textContent.toLowerCase();
          break;
        case "status":
          textToSearch = row.children[4]?.textContent.toLowerCase();
          break;
        case "team_leader":
          textToSearch = row.children[1]?.textContent.toLowerCase();
          break;
        default:
          textToSearch = row.textContent.toLowerCase(); 
      }

      if (textToSearch.includes(searchValue)) {
        row.style.display = ""; // Show matching rows
      } else {
        row.style.display = "none"; // Hide non-matching rows
      }
    });

    // Re-run pagination after filtering
    setupPaginationAfterFilter();
  }

  function setupPaginationAfterFilter() {
    const visibleRows = Array.from(document.querySelectorAll('.user-row')).filter(row => row.style.display !== "none");
    const rowsPerPage = 5;
    const totalPages = Math.ceil(visibleRows.length / rowsPerPage);
    const pagination = document.querySelector(".pagination");
    const prevBtn = pagination.querySelector(".prev-btn");
    const nextBtn = pagination.querySelector(".next-btn");

    let currentPage = 1;
    let paginationButtons = [];

    // Clear existing buttons except prev/next
    pagination.querySelectorAll(".page-btn").forEach(btn => btn.remove());

    if (totalPages === 0) {
      prevBtn.style.display = "none";
      nextBtn.style.display = "none";
      return;
    } else {
      prevBtn.style.display = "";
      nextBtn.style.display = "";
    }

    function createPaginationButtons() {
      for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        btn.className = "rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold page-btn";

        pagination.insertBefore(btn, nextBtn);

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

      visibleRows.forEach((row, index) => {
        row.style.display = (index >= start && index < end) ? "" : "none";
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

    prevBtn.onclick = () => {
      if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
      }
    };

    nextBtn.onclick = () => {
      if (currentPage < totalPages) {
        currentPage++;
        showPage(currentPage);
      }
    };

    createPaginationButtons();
    showPage(currentPage);
  }

  filterSelect.addEventListener('change', filterTable);
  searchInput.addEventListener('input', filterTable);
});