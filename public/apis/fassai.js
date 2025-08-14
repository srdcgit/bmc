// Replace with your Surepass API token
const API_TOKEN = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTc1NDk4NDU3MywianRpIjoiNmI0ZmNmYWQtZjIxYi00Yzc4LWJhM2QtN2FlYjM1NTc4ZWJmIiwidHlwZSI6ImFjY2VzcyIsImlkZW50aXR5IjoiZGV2LnNyaWRpcHRhcmVzZWFyY2hhbmRkZXZlbG9wbWVudGNvbnN1bHRhbmN5QHN1cmVwYXNzLmlvIiwibmJmIjoxNzU0OTg0NTczLCJleHAiOjE3NTc1NzY1NzMsImVtYWlsIjoic3JpZGlwdGFyZXNlYXJjaGFuZGRldmVsb3BtZW50Y29uc3VsdGFuY3lAc3VyZXBhc3MuaW8iLCJ0ZW5hbnRfaWQiOiJtYWluIiwidXNlcl9jbGFpbXMiOnsic2NvcGVzIjpbInVzZXIiXX19.CaDizhKxBYQ45dJtL93BVcEaXX8quNuRThBo3OQIITw";

document.getElementById("verifyBtn").addEventListener("click", async function () {
    const fssaiNumber = document.getElementById("trade_license_number").value.trim();

    if (!fssaiNumber) {
        alert("Please enter an FSSAI number");
        return;
    }

    try {
        const res = await fetch("https://sandbox.surepass.io/api/v1/corporate/fssai", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${API_TOKEN}`
            },
            body: JSON.stringify({ id_number: fssaiNumber })
        });

        const json = await res.json();

        if (res.status === 200 && json.success && json.data?.details?.length > 0) {
            const detail = json.data.details[0];

            // ✅ Make input border green
            const inputField = document.getElementById("trade_license_number");
            inputField.style.border = "2px solid green";

            // Build HTML table
            let html = `
                <table class="table table-bordered">
                    <tr><th>Company Name</th><td>${detail.company_name}</td></tr>
                    <tr><th>FSSAI Number</th><td>${json.data.fssai_number}</td></tr>
                    <tr><th>License Category</th><td>${detail.license_category_name}</td></tr>
                    <tr><th>Status</th><td>${detail.status_desc}</td></tr>
                    <tr><th>State</th><td>${detail.state_name}</td></tr>
                    <tr><th>Address</th><td>${detail.address}</td></tr>
                    <tr><th>Premise Pincode</th><td>${detail.premise_pincode}</td></tr>
                    <tr><th>Application Type</th><td>${detail.app_type_desc}</td></tr>
                </table>
            `;
            document.getElementById("fssaiData").innerHTML = html;

            // ✅ Open modal (Bootstrap 5 JS)
            const modal = new bootstrap.Modal(document.getElementById('fssaiModal'));
            modal.show();
            document.querySelector('input[name="trade_license_number"]').disabled = true;
            document.querySelector('input[name="fassai_verify"]').value = 1;

        } else {
            alert("No valid data found for this FSSAI number.");
        }

    } catch (err) {
        alert("Error verifying FSSAI number: " + err.message);
    }
});
