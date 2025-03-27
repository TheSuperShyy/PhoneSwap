<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../queries/phone_query.php';
require __DIR__ . '/../../dbcon/authentication.php';
require __DIR__ . '/../../dbcon/session_get.php';

?>


<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="../../src/output.css" />
  <script src="https://kit.fontawesome.com/10d593c5dc.js" crossorigin="anonymous"></script>
  <style>
    .dropdown-menu {
      display: none;
    }

    .dropdown:focus-within .dropdown-menu {
      display: block;
    }
  </style>
</head>

<bo <div class="flex">
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
          href="../audittrail.php">
          <i class="fas fa-list-alt mr-3"></i>
          Audit Trail
        </a>
      </li>
      <li class="mb-4">
        <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
          href="swapphones.php">
          <i class="fas fa-warehouse mr-3"></i>
          Swap Phones
        </a>
      </li>
      <li class="mb-4">
        <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
          href="usermanagement.php">
          <i class="fas fa-tools mr-3"></i>
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

      <!-- Notification Bell -->
      <div class="flex gap-4">
        <div class="flex flex-row items-center gap-4">

          <div class="relative inline-block text-left">
            <button class="relative text-2xl" aria-label="Notifications" id="notificationButton">
              <i class="fa-regular fa-bell"></i>
            </button>

            <!-- Dropdown Message Notification -->
            <div
              class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white border border-gray-400 ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
              role="menu" aria-orientation="vertical" aria-labelledby="notificationButton" id="notificationDropdown">
              <div class="py-1" role="none">
                <a href="#" class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100" role="menuitem">
                  <div class="flex">
                    <div>
                      <p class="font-medium">
                        New message from Yul Gatchalian
                      </p>
                      <p class="text-sm text-black-500">Lorem ipsum dolor sit amet.</p>
                      <p class="text-xs text-black-400">5 minutes ago</p>
                    </div>
                  </div>
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100" role="menuitem">
                  <div class="flex">
                    <div class="mr-3">
                      <p class="font-medium">Cylie Gonzales</p>
                      <p class="text-sm text-black-500">
                        Lorem ipsum dolor sit amet.
                      </p>
                      <p class="text-xs text-black-400">1 hour ago</p>
                    </div>
                  </div>
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100" role="menuitem">
                  <div class="flex">
                    <div class="mr-3">
                      <p class="font-medium">Kian David</p>
                      <p class="text-sm text-black-500">
                        Lorem ipsum dolor sit amet.
                      </p>
                      <p class="text-xs text-black-400">2 days ago</p>
                    </div>
                  </div>
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100" role="menuitem">
                  <div class="flex">
                    <div class="mr-3">
                      <p class="font-medium">Miko Basilio</p>
                      <p class="text-sm text-black-500">
                        Lorem ipsum dolor sit amet.
                      </p>
                      <p class="text-xs text-black-400">2 days ago</p>
                    </div>
                  </div>
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100" role="menuitem">
                  <div class="flex">
                    <div class="mr-3">
                      <p class="font-medium">Daniel Digo</p>
                      <p class="text-sm text-black-500">
                        Lorem ipsum dolor sit amet.
                      </p>
                      <p class="text-xs text-black-400">2 days ago</p>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
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
            <a href="../accountsetting.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Account Settings</a>
            <a href="../../src/logout.php" id="logoutBtn" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
                Logout
              </a>
          </div>
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
          <a href="dashboard.php" class="font-semibold laptop:text-lg phone:text-sm border-b-2 border-black">Assign
            Phones</a>
          <a href="managephones.php"
            class="font-semibold laptop:text-lg phone:text-sm hover:border-b-2 hover:border-black">Manage Phones</a>
          <a href="missingphones.php"
            class="font-semibold laptop:text-lg phone:text-sm hover:border-b-2 hover:border-black">Missing Phones</a>
        </div>
        <div class="flex flex-row gap-4">
          <!-- Filter and Search -->
          <div class="flex laptop:flex-row phone:flex-col gap-2 w-full">
            <div class="flex justify-start">
              <form method="" class="flex flex-row items-center">
                <select name="filter" id="filterSelect"
                  class="px-4 py-2 h-10 w-48 text-sm border border-gray-700 rounded-l-lg outline-none">
                  <option value="">Select Filter</option>
                  <option value="">Device Model</option>
                  <option value="">Serial Number</option>
                  <option value="">Table Number</option>
                  <option value="">Status</option>
                  <option value="">Assigned</option>
                  <option value="">Report</option>
                </select>
                <input type="text" name="" id="" placeholder="Search" value
                  class="w-full h-10 p-2 border border-gray-700 shadow-sm sm:text-sm outline-none rounded-r-lg" />
              </form>
            </div>
            <div class="flex ml-auto gap-2">
              <a href="">
                <button
                  class="flex items-center gap-2 border border-black bg-blue-950 hover:bg-blue-950 hover:bg-opacity-95 text-white px-4 py-2 rounded-lg shadow-md">
                  <i class="fa-solid fa-filter"></i></i><span>Export</span>
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Table section -->
      <div class="rounded-lg shadow-md mt-3">
        <div class="w-full overflow-x-auto h-full rounded-lg">
          <table class="w-full bg-white">
            <thead class="bg-gray-300">
              <tr class="text-left text-sm">
                <th class="py-3 px-4 border-b">Device Model</th>
                <th class="py-3 px-4 border-b">Serial Number</th>
                <th class="py-3 px-4 border-b">Table Number</th>
                <th class="py-3 px-4 border-b">Status</th>
                <th class="py-3 px-4 border-b">Team Leader</th>
                <th class="py-3 px-4 border-b">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($phones as $phone): ?>
                <tr class="border-b text-left">
                  <td class="py-2 px-4 flex items-center space-x-2">
                    <?php echo htmlspecialchars($phone['model']); ?>
                  </td>
                  <td class="py-2 px-4 whitespace-nowrap">
                    <?php echo htmlspecialchars($phone['serial_number']); ?>
                  </td>
                  <td class="py-2 px-4 whitespace-nowrap">
                    <?php echo $tableNumber == 0 ? 'Unassigned' : htmlspecialchars($tableNumber); ?>
                  </td>
                  <td class="py-2 px-4 whitespace-nowrap">
                    <?php if ($phone['status'] === 'Active'): ?>
                      <span
                        class="text-green-800 bg-green-100 border border-green-800 rounded-full py-2 px-6 font-medium shadow-lg">
                        Active
                      </span>
                    <?php elseif ($phone['status'] === 'Inactive'): ?>
                      <span
                        class="text-red-800 bg-red-100 border border-red-800 rounded-full py-2 px-6 font-medium shadow-lg">
                        Inactive
                      </span>
                    <?php elseif ($phone['status'] === 'Missing'): ?>
                      <span
                        class="text-red-800 bg-red-100 border border-red-800 rounded-full py-2 px-6 font-medium shadow-lg">
                        Missing
                      </span>
                    <?php else: ?>
                      <span
                        class="text-gray-800 bg-gray-100 border border-gray-800 rounded-full py-2 px-6 font-medium shadow-lg">
                        <?php echo htmlspecialchars($phone['status']); ?>
                      </span>
                    <?php endif; ?>
                  </td>
                  <td class="py-2 px-4 whitespace-nowrap">
                    <?php
                    // Fetch TL who has this phone assigned
                    $assignedTL = $db->users->findOne(['assigned_phone' => $phone['serial_number']]);
                    echo $assignedTL ? htmlspecialchars('( ' . '' . $assignedTL['hfId'] . ') ' . $assignedTL['first_name'] . ' ' . $assignedTL['last_name']) : 'Unassigned';
                    ?>
                  </td>
                  <td class="text-center space-x-2">
                    <div class="flex flex-row py-2 px-4 gap-2">
                      <button
                        onclick="openAssignModal('<?php echo $phone['serial_number']; ?>', '<?php echo $phone['model']; ?>')"
                        class="flex flex-row gap-2 items-center font-semibold border border-white bg-blue-500 hover:bg-blue-700 text-white px-6 py-1.5 rounded-full shadow-lg">
                        Assign
                      </button>
                      <button onclick="window.location.href='missingphones.php'"
                        class="flex flex-row gap-2 items-center border font-semibold border-white bg-red-700 hover:bg-red-900 text-white px-6 py-1.5 rounded-full shadow-lg">
                        Missing
                      </button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>


      <!-- Assign Phone Modal -->
      <div id="assignModal"
        class="fixed inset-0 flex justify-center hidden bg-black bg-opacity-50 z-50 pt-24 pb-24 h-full laptop:px-80 laptop:w-full phone:w-full phone:px-4">
        <div class="bg-white border border-gray-600 rounded-lg px-6 py-6 shadow-lg relative h-fit w-full max-w-md">
          <h2 class="text-2xl font-bold mb-4">Assign Phone to Team Leader</h2>

          <form id="assignForm">
            <!-- Device Model (Read-Only) -->
            <div class="mb-4">
              <label class="text-sm font-medium">Device Model</label>
              <input type="text" id="deviceModel" readonly
                class="border border-gray-700 p-2 w-full rounded-lg bg-gray-100">
            </div>

            <!-- Serial Number (Read-Only) -->
            <div class="mb-4">
              <label class="text-sm font-medium">Serial Number</label>
              <input type="text" id="serialNumber" readonly
                class="border border-gray-700 p-2 w-full rounded-lg bg-gray-100">
            </div>

            <!-- Select Team Leader -->
            <div class="mb-4">
              <label class="text-sm font-medium">Select Team Leader</label>
              <select id="teamLeaderSelect" class="border border-gray-700 p-2 w-full rounded-lg">
              </select>

            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2">
              <button type="button" id="closeAssignModal"
                class="w-24 px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-200">
                Cancel
              </button>
              <button type="submit" class="w-24 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">
                Assign
              </button>
            </div>
          </form>
        </div>
      </div>


      <!-- Pagination -->
      <div class="flex justify-end space-x-2 px-14 mb-4">
        <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
          <i class="fa-solid fa-angle-left"></i>
        </button>
        <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
          1
        </button>
        <button class="border border-gray-300 rounded-lg px-4 py-2 bg-amber-400 text-white font-medium">
          2
        </button>
        <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
          3
        </button>
        <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
          4
        </button>
        <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
          <i class="fa-solid fa-angle-right"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    console.log("JS Loaded");

    const assignModal = document.getElementById("assignModal");
    const closeAssignModal = document.getElementById("closeAssignModal");
    const assignForm = document.getElementById("assignForm");

    if (!assignModal) {
      console.error("Error: assignModal element not found!");
      return;
    }

    if (closeAssignModal) {
      closeAssignModal.addEventListener("click", function () {
        assignModal.classList.add("hidden");
        console.log("Modal closed");
      });
    } else {
      console.warn("Warning: closeAssignModal button not found.");
    }

    // ✅ Handle form submission
    assignForm.addEventListener("submit", function (event) {
      event.preventDefault(); // Prevent default form submission

      const serialNumber = document.getElementById("serialNumber").value;
      const deviceModel = document.getElementById("deviceModel").value;
      const teamLeaderId = document.getElementById("teamLeaderSelect").value; // This is hfId

      if (!serialNumber || !deviceModel || !teamLeaderId) {
        Swal.fire({
          icon: "warning",
          title: "Incomplete Details",
          text: "Please select all fields before assigning.",
          confirmButtonColor: "#3085d6"
        });
        return;
      }

      console.log("Assigning phone to Team Leader (hfId):", teamLeaderId);

      // ✅ Send assignment request to backend
      fetch("../manage_phones/assign_phone.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          serial_number: serialNumber,
          device_model: deviceModel,
          hfId: teamLeaderId,
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            Swal.fire({
              icon: "success",
              title: "Phone Assigned!",
              text: "The phone has been successfully assigned.",
              confirmButtonColor: "#3085d6"
            }).then(() => {
              assignModal.classList.add("hidden");
              location.reload(); // Reload the page to reflect changes
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: data.message,
              confirmButtonColor: "#d33"
            });
          }
        })
        .catch((error) => {
          console.error("Fetch Error:", error);
          Swal.fire({
            icon: "error",
            title: "Failed to Assign Phone",
            text: "An error occurred. Please try again.",
            confirmButtonColor: "#d33"
          });
        });
    });
  });

  // ✅ Open Assign Modal
  function openAssignModal(serial, model) {
    console.log("Opening modal for:", serial, model);

    const assignModal = document.getElementById("assignModal");
    const teamLeaderSelect = document.getElementById("teamLeaderSelect");

    if (!assignModal || !teamLeaderSelect) {
      console.error("Modal elements missing!");
      return;
    }

    document.getElementById("serialNumber").value = serial;
    document.getElementById("deviceModel").value = model;

    // ✅ Fetch Team Leaders
    fetch("../manage_phones/fetch_team_leaders.php")
      .then((response) => response.json())
      .then((data) => {
        console.log("Fetched Data:", data);

        if (!Array.isArray(data)) {
          console.error("Unexpected response format.");
          return;
        }

        teamLeaderSelect.innerHTML = `
          <option value="">Select Team Leader</option>
          <option value="unassigned">Unassigned</option>
        `;

        // ✅ Filter TLs
        const teamLeaders = data.filter(user => user.userType === "TL");

        if (teamLeaders.length === 0) {
          Swal.fire({
            icon: "info",
            title: "No Team Leaders Found",
            text: "There are no available Team Leaders to assign phones.",
            confirmButtonColor: "#3085d6"
          });
          teamLeaderSelect.innerHTML = '<option value="">No Team Leaders Found</option>';
          teamLeaderSelect.disabled = true;
        } else {
          teamLeaderSelect.disabled = false;
          teamLeaders.forEach((user) => {
            let displayName = `(${user.hfId}) ${user.username}`;
            teamLeaderSelect.innerHTML += `<option value="${user.hfId}">${displayName}</option>`;
          });
        }

        assignModal.classList.remove("hidden");
      })
      .catch((error) => {
        console.error("Fetch Error:", error);
        Swal.fire({
          icon: "error",
          title: "Fetch Error",
          text: "Failed to fetch team leaders. Please try again.",
          confirmButtonColor: "#d33"
        });
      });
  }
</script>


  <!-- Script for notification bell dropdown-->
  <script>
    const notificationButton = document.getElementById("notificationButton");
    const notificationDropdown = document.getElementById(
      "notificationDropdown"
    );

    notificationButton.addEventListener("click", () => {
      notificationDropdown.classList.toggle("hidden");
    });
  </script>



  </body>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- logout script -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const logoutBtn = document.getElementById("logoutBtn");

    if (logoutBtn) {
      logoutBtn.addEventListener("click", function (event) {
        event.preventDefault(); // ✅ Prevent default link behavior

        Swal.fire({
          title: "Are you sure?",
          text: "You will be logged out of your session.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Logout!"
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = logoutBtn.href; // ✅ Redirect after confirmation
          }
        });
      });
    }
  });
</script>



  </html>