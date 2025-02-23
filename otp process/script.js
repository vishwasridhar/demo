function sendOTP() {
    let contact = document.getElementById("contact").value;
    if (!contact) {
        alert("Please enter an email or phone number.");
        return;
    }

    fetch("send_otp.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ contact })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("otp-section").style.display = "block";
            document.getElementById("message").innerText = "OTP sent successfully!";
        } else {
            document.getElementById("message").innerText = "Error sending OTP.";
        }
    });
}

function verifyOTP() {
    let otp = document.getElementById("otp").value;
    
    fetch("verify_otp.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ otp })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("message").innerText = "OTP verified successfully!";
        } else {
            document.getElementById("message").innerText = "Invalid OTP!";
        }
    });
}
