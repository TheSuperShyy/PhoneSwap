
document.addEventListener("DOMContentLoaded", function () {
    const serialSelect = document.getElementById("serialNumberSelect");
    const modelInput = document.getElementById("deviceModel");

    serialSelect.addEventListener("change", function () {
        let selectedOption = serialSelect.options[serialSelect.selectedIndex];
        let modelValue = selectedOption.getAttribute("data-model");

        modelInput.value = modelValue || ""; // Auto-fill model or clear it
    });
});

//assign phone function 
document.addEventListener("DOMContentLoaded", function () {
    console.log("script.js is running and DOM is fully loaded!");
    const modal = document.getElementById("myModal");
    const openModalBtn1 = document.getElementById("openModalBtn1");
    const closeModalBtn1 = document.getElementById("closeModalBtn1");
    const modalCancelButton1 = document.getElementById("modalCancelButton1");
    const saveButton = document.getElementById("saveModalBtn1");
    const serialSelect = document.getElementById("serialNumberSelect");
    const teamSelect = document.getElementById("teamMemberSelect");

    // Open modal
    if (openModalBtn1) {
        openModalBtn1.addEventListener("click", () => modal.classList.remove("hidden"));
    }

    // Close modal (Cancel / Close buttons)
    [closeModalBtn1, modalCancelButton1].forEach(button => {
        if (button) button.addEventListener("click", () => modal.classList.add("hidden"));
    });

    // Save and assign phone
    if (saveButton) {
        saveButton.addEventListener("click", function (event) {
            event.preventDefault();

            const serialNumber = serialSelect.value.trim();
            const teamMember = teamSelect.value.trim();

            if (!serialNumber || !teamMember) {
                alert("Please select both a Serial Number and a Team Member.");
                return;
            }

            fetch("assign_phone.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ serial_number: serialNumber, team_member: teamMember })
            })
                .then(response => response.text()) // Read response as text
                .then(text => {
                    try {
                        return JSON.parse(text); // Try converting to JSON
                    } catch (error) {
                        throw new Error("Invalid JSON response: " + text);
                    }
                })
                .then(data => {
                    if (data.success) {
                        alert("Phone assigned successfully!");
                        modal.classList.add("hidden"); // Hide modal only on success
                        location.reload();
                    } else {
                        alert("Error: " + data.error);
                    }
                })
                .catch(error => console.error("Fetch Error:", error));
        });
    }
});
