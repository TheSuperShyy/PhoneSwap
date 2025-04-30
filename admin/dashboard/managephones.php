<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../queries/phone_query.php';
require __DIR__ . '/../../dbcon/authentication.php';
require __DIR__ . '/../../dbcon/session_get.php';
$phones = iterator_to_array($db->phones->find([]));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Phones</title>
  <link rel="icon" href="../src/assets/images/iconswap.svg" type="image/svg">
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
            href="../sidebar_pages/audittrail.php">
            <i class="fas fa-list-alt mr-3"></i>
            Audit Trail
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="../sidebar_pages/swapphones.php">
            <i class="fas fa-warehouse mr-3"></i>
            Swap Phones
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="../sidebar_pages/usermanagement.php">
            <i class="fas fa-tools mr-3"></i>
            User Management
          </a>
        </li>
        <li class="mb-4">
        <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
        href="../sidebar_pages/user_audit.php">
            <i class="fas fa-list-alt mr-3"></i>
            User Audit Log
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
          <h2 class="text-xl font-semibold mr-4">Manage Phones</h2>
        </div>

        <div class="flex gap-4">
          <div class="flex flex-row items-center gap-4">
            <!-- Notification Bell -->
            <div class="relative inline-block text-left">
              

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
              <a href="accountsetting.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Account Settings</a>
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
            <h4 class="text-4xl font-lg font-russo "><?php echo htmlspecialchars($totalPhones) ?></h4>
            <p class="text-base font-medium">Total Phone</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo htmlspecialchars($totalActivePhones) ?></h4>
            <p class="text-base font-medium">Active Phone</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo htmlspecialchars($totalInactivePhones) ?></h4>
            <p class="text-base font-medium">Inactive Phone</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo ">0</h4>
            <p class="text-base font-medium">Swap Phones</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo htmlspecialchars($totalMissingPhones) ?></h4>
            <p class="text-base font-medium">Missing Phones</p>
          </div>
        </div>

        <!-- navig section, filter, search and export button -->
        <div class="flex laptop:flex-row phone:flex-col gap-3 justify-between">
          <div class="flex flex-row gap-5 border-b border-black">
            <a href="dashboard.php"
              class="font-semibold laptop:text-lg phone:text-sm hover:border-b-2 hover:border-black">Assign Phones</a>
            <a href="managephones.php" class="font-semibold laptop:text-lg phone:text-sm border-b-2 border-black">Manage
              Phones</a>
            <a href="missingphones.php"
              class="font-semibold laptop:text-lg phone:text-sm hover:border-b-2 hover:border-black">Missing Phones</a>
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
                    <option value="">Team Leader</option>
                    <option value="">Action</option>
                  </select>
                  <input type="text" name="" id="" placeholder="Search" value
                    class="w-2/3 h-10 p-2 border border-gray-700 shadow-sm sm:text-sm outline-none rounded-r-lg" />
                </form>
              </div>
              <div class="flex flex-row ml-auto gap-2">
                <a href="">
                  <button
                    class="flex items-center gap-2 border border-black bg-white hover:bg-gray-100 hover:bg-opacity-95 text-black px-4 py-2 rounded-lg shadow-md">
                    <i class="fa-solid fa-filter"></i></i><span>Export</span>
                  </button>
                </a>
                <button id="openModalBtn2"
                  class="flex items-center gap-2 border border-black bg-blue-950 hover:bg-blue-950 hover:bg-opacity-95 text-white px-4 py-2 rounded-lg shadow-md">
                  <i class="fa-solid fa-circle-plus"></i><span>Add New</span>
                </button>
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
                  <tr class="border-b text-left user-row">
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
                          class="openModalBtn1 flex flex-row gap-2 items-center font-semibold border border-white bg-blue-500 hover:bg-blue-700 text-white px-6 py-1.5 rounded-full shadow-lg"
                          data-serial="<?= $phone['serial_number'] ?>" data-model="<?= $phone['model'] ?>">
                          <i class="fa-regular fa-pen-to-square"></i> Edit
                        </button>

                        <button
                          class="deleteModal flex flex-row gap-2 items-center border font-semibold border-white bg-red-700 hover:bg-red-900 text-white px-4 py-1.5 rounded-full shadow-lg"
                          data-serial="<?= $phone['serial_number'] ?>">
                          <i class="fa-solid fa-trash"></i> Delete
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Modal for edit phone details -->
        <div id="myModal1"
          class="fixed inset-0  justify-center items-center hidden bg-black bg-opacity-50 z-50 pt-24 pb-24 h-full laptop:px-80 laptop:w-full phone:w-full phone:px-4">
          <div class="bg-white border border-gray-600 rounded-lg px-6 py-6 shadow-lg relative h-fit w-full">
            <form action="../manage_phones/update_phone_status.php" method="POST">
              <div class="flex flex-col gap-4">
                <h2 class="text-3xl font-russo mb-2">Edit Phone</h2>

                <div class="flex flex-col gap-4">
                  <div class="flex laptop:flex-row phone:flex-col gap-4">
                    <div class="flex flex-col gap-2 w-full">
                      <label for="model" class="text-sm font-medium">Device Model</label>
                      <input type="text" id="deviceModel" name="model" readonly
                        class="border border-gray-700 p-2 w-full rounded-lg bg-gray-100">
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                      <label for="serial_number" class="text-sm font-medium">Serial Number</label>
                      <input type="text" id="serialNumber" name="serial_number" readonly
                        class="border border-gray-700 p-2 w-full rounded-lg bg-gray-100">
                    </div>
                  </div>
                  <div class="flex flex-col gap-2 w-full">
                    <label for="status" class="text-sm font-medium">Status</label>
                    <select name="status" id="statusSelect"
                      class="p-2 h-10 w-full text-sm border border-gray-700 rounded-lg outline-none" required>
                      <option value="">Select Status</option>
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                    </select>
                  </div>
                </div>
              </div>
              <br>
              <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="closeModalBtn1"
                  class="w-24 px-4 py-2 shadow-md shadow-gray-300 hover:ring-slate-400 text-black border border-black font-medium rounded-lg">
                  Cancel
                </button>
                <button type="submit"
                  class="px-4 py-2 w-24 shadow-md shadow-gray-300 bg-amber-400 font-medium text-black border border-black rounded-lg">
                  Save
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Add Phone Modal -->
        <div id="myModal2"
          class="fixed inset-0 justify-center items-center hidden bg-black bg-opacity-50 z-50 pt-24 pb-24 h-full laptop:px-80 laptop:w-full phone:w-full phone:px-4">
          <div class="bg-white border border-gray-600 rounded-lg px-6 py-6 shadow-lg relative h-fit w-full">
            <form id="addPhoneForm">
              <div class="flex flex-col gap-4">
                <h2 class="text-3xl font-russo mb-2">Add New Phone</h2>

                <div class="flex flex-col gap-4">
                  <div class="flex laptop:flex-row phone:flex-col gap-4">
                    <div class="flex flex-col gap-2 w-full">
                      <label for="deviceModel" class="text-sm font-medium">Device Model</label>
                      <input type="text" id="deviceModel" name="deviceModel" placeholder="Device Model"
                        class="border border-gray-700 p-2 rounded-lg" required>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                      <label for="serialNumber" class="text-sm font-medium">Serial Number</label>
                      <input type="text" id="serialNumber" name="serialNumber" placeholder="Enter Serial Number"
                        class="border border-gray-700 p-2 rounded-lg" required>
                    </div>
                  </div>
                  <div class="flex flex-col gap-2 w-full">
                    <label for="status" class="text-sm font-medium">Status</label>
                    <select name="status" id="status"
                      class="p-2 h-10 w-full text-sm border border-gray-700 rounded-lg outline-none" required>
                      <option value="">Select Status</option>
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                    </select>
                  </div>
                </div>
              </div>
              <br>
              <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="closeModalBtn2"
                  class="w-24 px-4 py-2 shadow-md shadow-gray-300 hover:ring-slate-400 text-black border border-black font-medium rounded-lg">
                  Cancel
                </button>
                <button type="submit"
                  class="px-4 py-2 w-24 shadow-md shadow-gray-300 bg-amber-400 font-medium text-black border border-black rounded-lg">
                  Save
                </button>
              </div>
            </form>
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

    <!-- delete script -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Select all delete buttons
        document.querySelectorAll(".deleteModal").forEach(button => {
          button.addEventListener("click", function () {
            let serialNumber = this.getAttribute("data-serial");

            Swal.fire({
              title: "Are you sure?",
              text: "To confirm, type 'DELETE' in the box below.",
              icon: "warning",
              input: "text",
              inputPlaceholder: "Type DELETE here...",
              showCancelButton: true,
              confirmButtonColor: "#d33",
              cancelButtonColor: "#3085d6",
              confirmButtonText: "Delete",
              cancelButtonText: "Cancel",
              inputValidator: (value) => {
                if (value !== "DELETE") {
                  return "You must type 'DELETE' to confirm!";
                }
              }
            }).then((result) => {
              if (result.isConfirmed) {
                // Send request to delete phone
                fetch("../manage_phones/delete_phone.php", {
                  method: "POST",
                  headers: { "Content-Type": "application/x-www-form-urlencoded" },
                  body: "serial_number=" + encodeURIComponent(serialNumber)
                })
                  .then(response => response.json())
                  .then(data => {
                    if (data.success) {
                      Swal.fire("Deleted!", "The phone has been removed.", "success")
                        .then(() => window.location.reload()); // Reload page to update list
                    } else {
                      Swal.fire("Error!", data.error, "error");
                    }
                  })
                  .catch(error => Swal.fire("Error!", "Something went wrong.", "error"));
              }
            });
          });
        });
      });
    </script>

    <!-- add phone script -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("addPhoneForm").addEventListener("submit", function (e) {
          e.preventDefault(); // Prevent default form submission

          let formData = new FormData(this);

          fetch("../manage_phones/add_phone.php", {
            method: "POST",
            body: formData
          })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                Swal.fire("Success!", "Phone has been added.", "success")
                  .then(() => window.location.reload()); // Reload page to update list
              } else {
                Swal.fire("Error!", data.error, "error");
              }
            })
            .catch(error => Swal.fire("Error!", "Something went wrong.", "error"));
        });

        // Close modal
        document.getElementById("closeModalBtn2").addEventListener("click", function () {
          document.getElementById("myModal2").classList.add("hidden");
        });
      });
    </script>


</body>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Script for modal edit assets -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const modal1 = document.getElementById("myModal1");
      const closeModalBtn1 = document.getElementById("closeModalBtn1");
      const editButtons = document.querySelectorAll(".openModalBtn1");

      const editForm = document.querySelector("#myModal1 form"); // Select the form inside modal

      editButtons.forEach(button => {
        button.addEventListener("click", function () {
          const serial = this.getAttribute("data-serial");
          const model = this.getAttribute("data-model");

          document.getElementById("serialNumber").value = serial;
          document.getElementById("deviceModel").value = model;

          // ✅ Show modal
          modal1.classList.remove("hidden");
        });
      });

      // ✅ Close modal when clicking cancel
      closeModalBtn1.addEventListener("click", function () {
        modal1.classList.add("hidden");
      });

      // ✅ Handle form submission with AJAX
      editForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        const formData = new FormData(this);

        fetch(this.action, {
          method: "POST",
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          console.log("Response Data:", data); // ✅ Debug response
          if (data.success) {
            Swal.fire({
              icon: "success",
              title: "Updated Successfully!",
              text: data.message,
              confirmButtonColor: "#3085d6",
            }).then(() => {
              modal1.classList.add("hidden"); // Close modal
              location.reload(); // Refresh page to update table
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error!",
              text: data.error,
              confirmButtonColor: "#d33",
            });
          }
        })
        .catch(error => {
          console.error("Error:", error);
          Swal.fire({
            icon: "error",
            title: "Oops!",
            text: "Something went wrong. Please try again.",
            confirmButtonColor: "#d33",
          });
        });
      });

    });
  </script>

<!-- Script for add modal -->
<script>
  const modal2 = document.getElementById('myModal2');
  const openModalBtn2 = document.getElementById('openModalBtn2');
  const closeModalBtn2 = document.getElementById('closeModalBtn2');
  const modalCancelButton2 = document.getElementById('modalBackButton2');

  openModalBtn2.addEventListener('click', () => {
    modal2.classList.remove('hidden');
  });

  closeModalBtn2.addEventListener('click', () => {
    modal2.classList.add('hidden');
  });

</script>


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

<!-- script for pagination -->
<script src="../../scripts/script.js"></script>

</html>