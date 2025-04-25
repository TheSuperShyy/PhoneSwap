<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../queries/phone_query.php';
require __DIR__ . '/../../dbcon/authentication.php';
require __DIR__ . '/../../dbcon/session_get.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Missing Phones</title>
  <link rel="stylesheet" href="../../src/output.css" />
  <script src="https://kit.fontawesome.com/10d593c5dc.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .dropdown-menu {
      display: none;
    }

    .dropdown:focus-within .dropdown-menu {
      display: block;
    }
  </style>
</head>

<body>
  <div class="flex">
    <!-- Sidebar -->
    <div class="w-1/5 bg-blue-950 text-white h-screen p-4 fixed">
      <h1 class="text-4xl mb-6 mt-2 font-medium font-russo">PhoneSwap</h1>
      <ul>
        <li class="mb-4">
          <a class="flex items-center bg-opacity-30 bg-white p-2 text-base font-medium rounded-lg" href="dashboard.php">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="../sidepanels/swapphones.php">
            <i class="fa-solid fa-arrows-rotate mr-3"></i>
            Swap Phones
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="../sidepanels/usermanagement.php">
            <i class="fa-solid fa-user-group mr-3"></i>
            User Management
          </a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="w-4/5 ml-auto">
      <!-- Navbar section -->
      <div class="fixed w-4/5 bg-gray-200 z-10 px-6 py-3 flex justify-between items-center">
        <!-- Menubar -->
        <div class="flex flex-row items-center gap-4">
          <button class="text-black focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>
          <h2 class="text-xl font-semibold mr-4">Dashboard</h2>
        </div>

        <!-- Avatarbar -->
        <div class="relative dropdown">
          <button
            class="flex flex-row items-center gap-3 border border-black shadow-gray-700 shadow-sm bg-amber-400 text-black px-4 w-fit rounded-xl">
            <i class="fa-regular fa-user fa-xl"></i>
            <div class="flex flex-col items-start">
              <h1 class="font-medium"><?= htmlspecialchars($userName) ?></h1>
              <h1 class="text-sm"><?= htmlspecialchars($userRole) ?></h1>
            </div>
            <i class="fa-solid fa-angle-down fa-sm pl-3"></i>
          </button>
          <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden">
            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profile</a>
            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Settings</a>
            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="pt-22 py-6 laptop:px-10 phone:px-6">
        <h3 class="text-xl font-semibold mb-4">Overview</h3>
        <div class="flex laptop:flex-row phone:flex-col gap-4 mb-6">
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo $totalPhones; ?></h4>
            <p class="text-base font-medium">Total Phone</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo $totalActivePhones; ?></h4>
            <p class="text-base font-medium">Active Phone</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo $totalInactivePhones; ?></h4>
            <p class="text-base font-medium">Inactive Phone</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo ">0</h4>
            <p class="text-base font-medium">Swap Phones</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo $totalMissingPhones; ?></h4>
            <p class="text-base font-medium">Missing Phones</p>
          </div>
        </div>

        <!-- navig section, filter, search and export button -->
        <div class="flex laptop:flex-row phone:flex-col gap-3 justify-between">
          <div class="flex flex-row gap-5 border-b border-black">
            <a href="dashboard.php"
              class="font-semibold laptop:text-lg phone:text-sm hover:border-b-2 hover:border-black">Assign Phones</a>
            <a href="missingphones.php"
              class="font-semibold laptop:text-lg phone:text-sm border-b-2 border-black">Missing Phones</a>
          </div>
          <div class="flex flex-row gap-4">
            <!-- Filter and Search -->
            <div class="flex laptop:flex-row phone:flex-col gap-2 w-full">
              <div class="flex justify-start">
                <form method="" class="flex flex-row items-center">
                  <select name="filter" id="filterSelect"
                    class="px-4 py-2 h-10 w-36 text-sm border border-gray-700 rounded-l-lg outline-none">
                    <option value="">Select Filter</option>
                    <option value="">Device Model</option>
                    <option value="">Serial Number</option>
                    <option value="">Table Number</option>
                    <option value="">Status</option>
                    <option value="">Assigned</option>
                    <option value="">Report</option>
                  </select>
                  <input type="text" name="" id="" placeholder="Search" value
                    class="w-2/3 h-10 p-2 border border-gray-700 shadow-sm sm:text-sm outline-none rounded-r-lg" />
                </form>
              </div>
              <div class="flex flex-row ml-auto gap-2">
                <button id="foundBtn" onclick="handleFoundClick()"
                  class="flex items-center gap-2 border border-white bg-amber-400 hover:bg-amber-600 hover:bg-opacity-95 text-white px-4 py-2 rounded-lg shadow-md"
                  disabled>
                  <i class="fa-solid fa-circle-check"></i>
                  <span>Found</span>
                </button>


                <a href="">
                  <button
                    class="flex items-center gap-2 border border-white bg-blue-950 hover:bg-blue-800 hover:bg-opacity-95 text-white px-4 py-2 rounded-lg shadow-md">
                    <i class="fa-solid fa-filter"></i></i><span>Export</span>
                  </button>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Audit trail table -->
        <div class="rounded-lg shadow-md mt-3">
          <div class="w-full overflow-x-auto h-full rounded-lg">
            <table class="w-full bg-white">
              <thead class="bg-gray-300">
                <tr class="text-left text-sm">
                  <th class="py-3 px-4 border-b">
                    <input type="checkbox" onclick="toggleSelectAll(this)" />
                  </th>
                  <th class="py-3 px-4 border-b">Device Model</th>
                  <th class="py-3 px-4 border-b">Serial Number</th>
                  <th class="py-3 px-4 border-b">Status</th>
                  <th class="py-3 px-4 border-b">Team Member</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($assignedPhones as $serial): ?>
                  <?php
                  // Fetch the full phone document by serial number
                  $phone = $db->phones->findOne(['serial_number' => $serial]);

                  if (!$phone) {
                    continue; // Skip if not found
                  }

                  // Only process if the phone's status is "Missing"
                  if ($phone['status'] === 'Missing'):
                    // Check if this phone is assigned to a TM under the TL
                    $assignedUser = $db->users->findOne([
                      "assigned_phone" => $serial,
                      "userType" => "TM",
                      "hfId" => ['$in' => $teamMembers]
                    ]);
                    ?>
                    <tr class="border-b text-left">
                      <td class="py-2 px-4 whitespace-nowrap">
                        <input type="checkbox" name="foundCheckbox" value="<?php echo $phone['serial_number']; ?>">
                      </td>
                      <td class="py-2 px-4 flex items-center space-x-2">
                        <?php echo htmlspecialchars($phone['model']); ?>
                      </td>
                      <td class="py-2 px-4 whitespace-nowrap">
                        <?php echo htmlspecialchars($phone['serial_number']); ?>
                      </td>
                      <td class="py-3 px-4 whitespace-nowrap">
                        <span
                          class="text-red-800 bg-red-50 border border-red-800 rounded-full py-2 px-6 font-medium shadow-lg">
                          Missing
                        </span>
                      </td>
                      <td class="py-2 px-4 whitespace-nowrap">
                        <?php if ($assignedUser): ?>
                          <?php
                          $fullName = htmlspecialchars($assignedUser['first_name'] . ' ' . $assignedUser['last_name']);
                          echo '[' . htmlspecialchars($assignedUser['hfId']) . '] ' . $fullName;
                          ?>
                        <?php else: ?>
                          <span>Unassigned</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endif; ?>
                <?php endforeach; ?>
              </tbody>

            </table>
          </div>
        </div>

        <!-- Pagination -->
        <div class="pagination flex justify-end space-x-2 px-14 mb-4" id="pagination">
          <button class="prev-btn rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
            <i class="fa-solid fa-angle-left"></i>
          </button>
          <!-- Numbered buttons will be generated here by JS -->
          <button class="next-btn rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
            <i class="fa-solid fa-angle-right"></i>
          </button>
        </div>
      </div>
    </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>
  const checkboxes = document.querySelectorAll('input[name="foundCheckbox"]');
  const foundBtn = document.getElementById('foundBtn');
  const selectAllCheckbox = document.querySelector('input[onclick="toggleSelectAll(this)"]');

  // Enable button if any checkbox is selected
  function updateFoundBtnState() {
    const anyChecked = [...checkboxes].some(c => c.checked);
    foundBtn.disabled = !anyChecked;
  }

  checkboxes.forEach(cb => {
    cb.addEventListener('change', () => {
      updateFoundBtnState();

      // Automatically update selectAllCheckbox state
      if (!cb.checked && selectAllCheckbox.checked) {
        selectAllCheckbox.checked = false;
      } else if ([...checkboxes].every(c => c.checked)) {
        selectAllCheckbox.checked = true;
      }
    });
  });

  // Select All Toggle
  function toggleSelectAll(source) {
    checkboxes.forEach(cb => {
      cb.checked = source.checked;
    });
    updateFoundBtnState();
  }

  function handleFoundClick() {
    const selected = [...document.querySelectorAll('input[name="foundCheckbox"]:checked')];
    if (selected.length === 0) return;

    // Show SweetAlert confirmation
    Swal.fire({
      title: 'Confirm Phone Recovery',
      text: "Are you sure you want to mark the selected phone(s) as found?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, mark as found',
      cancelButtonText: 'Cancel'
    }).then(result => {
      if (result.isConfirmed) {
        // Create form to submit data to the PHP handler
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../controls/found_multiple.php'; // Your backend handler

        selected.forEach(cb => {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'serials[]';
          input.value = cb.value; // Value of the selected checkbox
          form.appendChild(input);
        });

        // Use fetch to submit the form data via AJAX
        fetch(form.action, {
          method: form.method,
          body: new FormData(form)
        })
          .then(response => response.json()) // Parse the JSON response from PHP
          .then(data => {
            if (data.success) {
              // Success! Show SweetAlert success message
              Swal.fire('Success', `Marked ${data.updatedCount} phone(s) as Found.`, 'success')
                .then(() => {
                  // Redirect to missingphones.php after success
                  window.location.href = 'missingphones.php'; // This will redirect to the page
                });
            } else {
              // Error case (e.g. no phones selected)
              Swal.fire('Error', data.message || 'Something went wrong.', 'error');
            }
          })
          .catch(error => {
            // Handle any errors with the fetch request
            Swal.fire('Error', 'Something went wrong. Please try again later.', 'error');
          });
      }
    });
  }
</script>

<!-- script for pagination -->
<script>
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
</script>

</html>