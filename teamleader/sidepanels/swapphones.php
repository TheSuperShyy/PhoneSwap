<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../queries/phone_query.php';
require __DIR__ . '/../../dbcon/authentication.php';
require __DIR__ . '/../../dbcon/session_get.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Swap Phones</title>
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
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="../dashboard/dashboard.php">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center bg-opacity-30 bg-white p-2 text-base font-medium rounded-lg"
            href="swapphones.php">
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

        <div class="flex gap-4">
          <div class="flex flex-row items-center gap-4">
            <!-- Notification Bell -->
            <div class="relative inline-block text-left">

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
                  <a href="accountsetting.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Account
                    Settings</a>
                  <a href="../../src/logout.php" id="logoutBtn" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
                    Logout
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="pt-22 py-6 laptop:px-10 phone:px-6">
        <!-- contents -->
        <div class="flex flex-col gap-1 items-end justify-center w-full mx-auto">
          <div class="flex flex-col gap-3 mx-auto py-4 w-full">
            <!-- navig section, filter, search and export button -->
            <div class="flex laptop:flex-row phone:flex-col gap-3 justify-between">
              <div class="flex flex-row gap-5 border-b border-black">
                <a href="swapphones.php" class="font-semibold laptop:text-lg phone:text-sm border-b-2 border-black">Swap
                  Phones</a>
                <a href="swappedphones.php"
                  class="font-semibold laptop:text-lg phone:text-sm hover:border-b-2 hover:border-black">Swapped
                  Phones</a>
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
                        <option value="">Status</option>
                        <option value="">Assigned</option>
                        <option value="">Report</option>
                      </select>
                      <input type="text" name="" id="" placeholder="Search" value
                        class="w-2/3 h-10 p-2 border border-gray-700 shadow-sm sm:text-sm outline-none rounded-r-lg" />
                    </form>
                  </div>
                  <div class="flex ml-auto gap-2">
                    <button
                      class="flex items-center gap-2 border border-white bg-blue-950 hover:bg-blue-950 hover:bg-opacity-95 text-white px-4 py-2 rounded-lg shadow-md">
                      <i class="fa-solid fa-filter"></i></i><span>Export</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Swap Phones Table -->
            <div class="w-full overflow-x-auto h-full border border-gray-300 rounded-lg shadow-md">
              <table class="w-full bg-white pl-7">
                <thead>
                  <tr class="bg-gray-200 border-b border-gray-400 text-sm text-left px-4">

                    <th class="py-3 px-4 whitespace-nowrap">Device Model</th>
                    <th class="py-3 px-4 whitespace-nowrap">Serial Number</th>
                    <th class="py-3 px-4 whitespace-nowrap">Status</th>
                    <th class="py-3 px-4 whitespace-nowrap">Team Member</th>
                    <th class="py-3 px-4 whitespace-nowrap">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Fetch all Team Members (TM)
                  $teamMembers = $db->users->find(['userType' => 'TM']);

                  foreach ($teamMembers as $tm) {
                    // Ensure 'assigned_phone' exists and is an array
                    $tmPhones = $tm['assigned_phone'] ?? [];

                    foreach ($tmPhones as $serial) {
                      // Get the phone details by serial number
                      $phone = $db->phones->findOne(['serial_number' => $serial]);

                      if (!$phone) {
                        continue; // If no phone found, skip this iteration
                      }

                      // Determine the status class for styling
                      $status = $phone['status'];
                      $statusClass = match ($status) {
                        'Active' => 'text-green-800 bg-green-100 border-green-800',
                        'Missing', 'Inactive' => 'text-red-800 bg-red-100 border-red-800',
                        default => 'text-gray-800 bg-gray-100 border-gray-800',
                      };
                      ?>

                      <!-- Table Row for Phone Details -->
                      <tr class="border-b user-row">
                        <!-- Phone Model Column -->
                        <td class="py-5 px-4 whitespace-nowrap"><?= htmlspecialchars($phone['model']) ?></td>

                        <!-- Serial Number Column -->
                        <td class="py-5 px-4 whitespace-nowrap"><?= htmlspecialchars($phone['serial_number']) ?></td>

                        <!-- Status Column -->
                        <td class="py-2 px-4 whitespace-nowrap">
                          <span class="<?= $statusClass ?> rounded-full py-2 px-6 font-medium shadow-lg">
                            <?= htmlspecialchars($status) ?>
                          </span>
                        </td>

                        <!-- Assigned To Column -->
                        <td class="py-5 px-4 whitespace-nowrap">
                          <?= htmlspecialchars('[' . $tm['hfId'] . '] ' . $tm['first_name'] . ' ' . $tm['last_name']) ?>
                        </td>

                        <!-- Swap Button Column -->
                        <td class="py-2 px-4 whitespace-nowrap">
                          <button
                            class="swap-button flex flex-row gap-2 items-center border font-semibold border-black bg-amber-400 hover:bg-amber-600 text-black px-6 py-1.5 rounded-full shadow-lg"
                            onclick='openSwapModal([{
                                "model": "<?= htmlspecialchars($phone['model']) ?>", 
                                "serial_number": "<?= htmlspecialchars($phone['serial_number']) ?>", 
                                "assigned_to": "<?= htmlspecialchars($tm['first_name'] . ' ' . $tm['last_name']) ?>"
                              }])'>
                            Swap
                          </button>
                        </td>
                      </tr>

                      <?php
                    }
                  }
                  ?>
                </tbody>

              </table>
            </div>
          </div>

          <!-- 📱 Modal for Swapping Phones -->
          <div id="swapModal"
            class="fixed inset-0 flex justify-center hidden bg-black bg-opacity-50 z-50 pt-24 pb-24 h-full laptop:px-80 laptop:w-full phone:w-full phone:px-4">
            <div class="bg-white border border-gray-600 rounded-lg px-6 py-6 shadow-lg relative h-fit w-full">
              <div class="flex flex-col gap-4">
                <h2 class="text-2xl font-russo mb-2">Swap Phone</h2>

                <!-- 📦 Selected Phones Container -->
                <div id="selectedPhonesContainer" class="flex flex-col gap-3 max-h-52 overflow-y-auto">
                  <!-- dynamically inserted phone cards -->
                </div>

                <!-- 🔄 Available Phones Dropdown -->
                <div class="flex flex-col gap-2 w-full">
                  <label for="availablePhones" class="text-sm font-medium">Available Phones</label>
                  <select id="availablePhones"
                    class="p-2 h-10 w-full text-md border border-gray-700 rounded-lg outline-none">
                    <option disabled selected>Loading...</option>
                  </select>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                  <button onclick="closeModal()"
                    class="w-24 px-4 py-2 shadow-md shadow-gray-300 hover:ring-slate-400 text-black border border-black font-medium rounded-lg">
                    Cancel
                  </button>
                  <button id="confirmSwapBtn"
                    class="w-24 px-4 py-2 shadow-md shadow-gray-300 bg-amber-400 text-black border border-black font-medium rounded-lg hover:bg-amber-500"
                    onclick="confirmSwap()">
                    Swap
                  </button>

                </div>
              </div>
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


<script>
  let currentSwapPhone = null; // 📌 global variable to store selected phone

  function openSwapModal(selectedPhones = []) {
    document.getElementById('swapModal').classList.remove('hidden');

    const container = document.getElementById('selectedPhonesContainer');
    container.innerHTML = '';

    // We'll only use the first phone in this context
    const phone = selectedPhones[0];
    currentSwapPhone = phone; // ⬅️ Save for later swap

    const phoneCard = document.createElement('div');
    phoneCard.className = 'border border-gray-400 p-2 rounded-md shadow-sm';
    phoneCard.innerHTML = `
      <div class="text-lg font-semibold">📱 ${phone.model}</div>
      <div class="text-md text-gray-700">SN: ${phone.serial_number}</div>
      <div class="text-md text-gray-600">👤 Holder: ${phone.assigned_to}</div>
    `;
    container.appendChild(phoneCard);

    fetchUnassignedPhones();
  }

  function closeModal() {
    document.getElementById('swapModal').classList.add('hidden');
    currentSwapPhone = null; // clear after use
  }

  function fetchUnassignedPhones() {
    fetch("../controls/fetch_team_Members.php")
      .then(res => res.json())
      .then(tmData => {
        if (!tmData.success) return;

        const teamMembers = tmData.data;

        fetch('../controls/get_phones.php')
          .then(res => res.json())
          .then(phoneData => {
            if (!phoneData.success) return;

            const unassignedPhones = phoneData.data.filter(phone => {
              return !teamMembers.some(tm =>
                tm.assigned_phone?.includes(phone.serial_number)
              );
            });

            updatePhoneDropdown(unassignedPhones);
          });
      });
  }

  function updatePhoneDropdown(phones) {
    const dropdown = document.getElementById('availablePhones');
    dropdown.innerHTML = '';

    if (phones.length === 0) {
      dropdown.innerHTML = '<option disabled>No available phones</option>';
    } else {
      phones.forEach(phone => {
        const option = document.createElement('option');
        option.value = phone.serial_number;
        option.textContent = `${phone.model} (${phone.serial_number})`;
        dropdown.appendChild(option);
      });
    }
  }

  // ✅ Confirm swap handler
  function confirmSwap() {
    const newSerial = document.getElementById('availablePhones').value;
    const oldSerial = currentSwapPhone.serial_number;
    const assignedTo = currentSwapPhone.assigned_to;

    if (!newSerial || !assignedTo) {
      alert("Missing swap details.");
      return;
    }

    // Send the swap request to the server
    fetch('../controls/swap_phone.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        old_serial: currentSwapPhone.serial_number,
        new_serial: document.getElementById('availablePhones').value,
        assigned_to: currentSwapPhone.assigned_to
      })
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Swap Successful',
            text: data.message,
            confirmButtonColor: '#3085d6'
          }).then(() => {
            // Optional: reload or close modal
            closeModal();
            location.reload(); // Or any custom logic
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Swap Failed',
            text: data.message
          });
        }
      })
      .catch(error => {
        console.error("Swap error:", error);
        Swal.fire({
          icon: 'error',
          title: 'Something went wrong',
          text: 'Please try again later.'
        });
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