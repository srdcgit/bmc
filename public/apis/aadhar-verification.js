$(document).ready(function () {
    console.log('Document ready - jQuery is loaded');


    // Bind click event to the Verify button using its class
    $('.btn.btn-primary.ml-2').on('click', function (e) {
        e.preventDefault();
        console.log('Verify button clicked');
        verifyIdProof();
    });

    let popupWindow = null;
    let clientId = null;

    async function verifyIdProof() {
        console.log('verifyIdProof function called');
        const idProof = $('select[name="id_proof"]').val();
        const idProofNumber = $('input[name="id_proof_number"]').val();
        const responseDiv = $('#response');

        // Clear previous response
        responseDiv.empty();
        console.log('Selected ID Proof:', idProof, 'ID Proof Number:', idProofNumber);

        // Validation
        if (idProof !== "Aadhar Card") {
            responseDiv.html('<div class="error">Please select "Aadhar Card" for verification.</div>');
            console.log('Validation failed: ID Proof must be Aadhar Card');
            return;
        }
        if (!idProofNumber || !/^\d{12}$/.test(idProofNumber)) {
            responseDiv.html('<div class="error">Please enter a valid 12-digit Aadhaar number.</div>');
            console.log('Validation failed: Invalid Aadhaar number');
            return;
        }



        console.log('Validation passed, initiating API call');
        try {
            const response = await fetch('https://sandbox.surepass.app/api/v1/digilocker/initialize', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTc1NDk4NDU3MywianRpIjoiNmI0ZmNmYWQtZjIxYi00Yzc4LWJhM2QtN2FlYjM1NTc4ZWJmIiwidHlwZSI6ImFjY2VzcyIsImlkZW50aXR5IjoiZGV2LnNyaWRpcHRhcmVzZWFyY2hhbmRkZXZlbG9wbWVudGNvbnN1bHRhbmN5QHN1cmVwYXNzLmlvIiwibmJmIjoxNzU0OTg0NTczLCJleHAiOjE3NTc1NzY1NzMsImVtYWlsIjoic3JpZGlwdGFyZXNlYXJjaGFuZGRldmVsb3BtZW50Y29uc3VsdGFuY3lAc3VyZXBhc3MuaW8iLCJ0ZW5hbnRfaWQiOiJtYWluIiwidXNlcl9jbGFpbXMiOnsic2NvcGVzIjpbInVzZXIiXX19.CaDizhKxBYQ45dJtL93BVcEaXX8quNuRThBo3OQIITw'
                },
                body: JSON.stringify({
                    data: {
                        signup_flow: true,
                        logo_url: 'https://example.com/logo.png',
                        skip_main_screen: false,
                        redirect_url: window.location
                            .href // Callback to the current page (adjust as needed)
                    }
                })
            });

            console.log('API response received, status:', response.status);
            const data = await response.json();
            console.log('API response data:', JSON.stringify(data, null, 2));

            if (response.ok) {
                clientId = data.data?.client_id;
                const token = data.data?.token;
                if (token && clientId) {
                    console.log('Token and Client ID received:', {
                        token,
                        clientId
                    });
                    const authUrl =
                        `https://digilocker-sdk.notbot.in/?gateway=sandbox&type=digilocker&token=${encodeURIComponent(token)}&auth_type=web`;
                    console.log('Constructed auth URL:', authUrl);
                    popupWindow = window.open(authUrl, 'DigiLockerAuth',
                        'width=600,height=400,top=100,left=100');
                    if (!popupWindow) {
                        responseDiv.html(
                            '<div class="error">Popup blocked. Please allow popups and try again.</div>'
                        );
                        console.log('Popup blocked by browser');
                    } else {
                        responseDiv.html(
                            '<div class="info">Popup opened for DigiLocker authorization. Awaiting consent...</div>'
                        );
                        console.log('Popup opened successfully');
                        checkPopupStatus();
                    }
                } else {
                    responseDiv.html(
                        '<div class="error">No token or client_id received from API.</div>');
                    console.log('No token or client_id in response');
                }
            } else {
                responseDiv.html(
                    `<div class="error">Error: ${data.message || 'Failed to initialize verification'}</div>`
                );
                console.log('API error:', data.message);
            }
        } catch (error) {
            responseDiv.html(`<div class="error">Error: ${error.message}</div>`);
            console.log('Fetch error:', error);
        }
    }

    function checkPopupStatus() {
        const interval = setInterval(() => {
            if (popupWindow && popupWindow.closed) {
                clearInterval(interval);
                console.log('Popup closed, fetching verified data');
                fetchVerifiedData();
            }
        }, 1000); // Check every second
    }

    async function fetchVerifiedData() {
        if (!clientId) {
            console.log('No client_id available to fetch verified data');
            return;
        }

        try {
            const response = await fetch(
                `https://sandbox.surepass.app/api/v1/digilocker/download-aadhaar/${clientId}`,
                {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTc1NDk4NDU3MywianRpIjoiNmI0ZmNmYWQtZjIxYi00Yzc4LWJhM2QtN2FlYjM1NTc4ZWJmIiwidHlwZSI6ImFjY2VzcyIsImlkZW50aXR5IjoiZGV2LnNyaWRpcHRhcmVzZWFyY2hhbmRkZXZlbG9wbWVudGNvbnN1bHRhbmN5QHN1cmVwYXNzLmlvIiwibmJmIjoxNzU0OTg0NTczLCJleHAiOjE3NTc1NzY1NzMsImVtYWlsIjoic3JpZGlwdGFyZXNlYXJjaGFuZGRldmVsb3BtZW50Y29uc3VsdGFuY3lAc3VyZXBhc3MuaW8iLCJ0ZW5hbnRfaWQiOiJtYWluIiwidXNlcl9jbGFpbXMiOnsic2NvcGVzIjpbInVzZXIiXX19.CaDizhKxBYQ45dJtL93BVcEaXX8quNuRThBo3OQIITw'
                    }
                }
            );

            console.log('Download-aadhaar response status:', response.status);
            const data = await response.json();
            console.log('Verified Aadhaar data:', JSON.stringify(data, null, 2));

            if (response.ok && data.data?.aadhaar_xml_data) {
                const a = data.data.aadhaar_xml_data;

                // Base64 image handling
                const profileImgSrc = a.profile_image
                    ? `data:image/jpeg;base64,${a.profile_image}`
                    : "";

                // Build HTML table
                let html = `
                <div class="row">
                    <div class="col-md-3 text-center">
                        ${profileImgSrc ? `<img src="${profileImgSrc}" class="img-fluid rounded border" alt="Profile" />` : `<div class="text-muted">No Image</div>`}
                    </div>
                    <div class="col-md-9">
                        <table class="table table-bordered">
                            <tr><th>Full Name</th><td>${a.full_name}</td></tr>
                            <tr><th>Care Of</th><td>${a.care_of}</td></tr>
                            <tr><th>Date of Birth</th><td>${a.dob}</td></tr>
                            <tr><th>Year of Birth</th><td>${a.yob}</td></tr>
                            <tr><th>Gender</th><td>${a.gender}</td></tr>
                            <tr><th>Masked Aadhaar</th><td>${a.masked_aadhaar}</td></tr>
                            <tr><th>ZIP</th><td>${a.zip}</td></tr>
                            <tr><th>Full Address</th><td>${a.full_address}</td></tr>
                            <tr><th>Father's Name</th><td>${a.father_name ?? "N/A"}</td></tr>
                            <tr><th>Country</th><td>${a.address.country}</td></tr>
                            <tr><th>State</th><td>${a.address.state}</td></tr>
                            <tr><th>District</th><td>${a.address.dist}</td></tr>
                            <tr><th>Post Office</th><td>${a.address.po}</td></tr>
                            <tr><th>House</th><td>${a.address.house}</td></tr>
                            <tr><th>Locality</th><td>${a.address.loc}</td></tr>
                            <tr><th>Street</th><td>${a.address.street}</td></tr>
                            <tr><th>Landmark</th><td>${a.address.landmark}</td></tr>
                        </table>
                    </div>
                </div>
            `;

                document.getElementById("aadhaarData").innerHTML = html;

                // ✅ Show the modal
                const modal = new bootstrap.Modal(document.getElementById('aadhaarModal'));
                modal.show();
                document.querySelector('input[name="id_proof_number"]').disabled = true;

            } else {
                console.log('Verification error:', data.message);
                alert("Unable to fetch Aadhaar details.");
            }
        } catch (error) {
            console.log('Fetch verified data error:', error);
            alert("Error fetching Aadhaar details.");
        }
    }

});
