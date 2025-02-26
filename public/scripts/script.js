function initializeInputFields() {
    //
    const inputFields = document.querySelectorAll("input, button, select");
    //
    inputFields.forEach((field) => {

        field.addEventListener("keydown", handleKeyboardNavigation);
    });
    //
    function handleKeyboardNavigation(event) {
        const currentField = event.target;
        const currentIndex = Array.from(inputFields).indexOf(currentField);
        if (currentIndex == 0) {
            currentField.focus();
        }
        if (event.key === "Enter" && currentField.type != 'submit') {
            event.preventDefault();
            const nextField = inputFields[currentIndex + 1];
            if (nextField) {
                nextField.focus();
            }
        }
        if (event.key === "Backspace" && currentField.value.length === 0) {
            const previousField = inputFields[currentIndex - 1];
            if (previousField) {
                previousField.focus();
            }
        }
    }
}
document.addEventListener("DOMContentLoaded", () => {
    initializeInputFields();
});
//
function showQrCode(studentId, studentName, studentClass) {
    document.getElementById("qr-code-response").innerHTML = "";

    let qrDiv = document.getElementById("qr-code-response");
    let overlay = document.getElementById("qr-code-response-overlayer");

    overlay.style.display = "block";

    qrDiv.style.display = "grid";
    qrDiv.style.gridTemplateColumns = "repeat(auto-fill, minmax(200px, 1fr))";
    qrDiv.style.gap = "10px";
    qrDiv.style.justifyContent = "center";
    qrDiv.style.alignItems = "center";

    let qrContainer = document.createElement("div");
    qrContainer.style.textAlign = "left";

    let qrCode = document.createElement("div");
    new QRCode(qrCode, {
        text: `http://127.0.0.1:8000/School/showQrCode/${studentId}`,
        width: 200,
        height: 200
    });

    let studentInfo = document.createElement("div");
    studentInfo.style.textAlign = "left";
    studentInfo.style.marginTop = "10px";
    studentInfo.style.fontSize = "1.2em";
    studentInfo.style.fontWeight = "500";
    studentInfo.innerHTML = `${studentName} Class - ${studentClass}`;

    let printControls = document.createElement("div");
    printControls.style.marginTop = "15px";
    printControls.style.display = "flex";
    printControls.style.alignItems = "start";
    printControls.style.justifyContent = "start";
    printControls.style.gap = "10px";

    let qtyInput = document.createElement("input");
    qtyInput.type = "number";
    qtyInput.value = 1;
    qtyInput.min = 1;
    qtyInput.style.width = "30px";
    qtyInput.style.fontSize = "14px";
    qtyInput.style.border = "none";
    qtyInput.style.textAlign = "center";
    qtyInput.style.padding = "0px";
    qtyInput.style.margin = "0px";

    let plusButton = document.createElement("button");
    plusButton.innerText = "+";
    plusButton.onclick = function () {
        qtyInput.value = parseInt(qtyInput.value) + 1;
    };

    let minusButton = document.createElement("button");
    minusButton.innerText = "-";
    minusButton.onclick = function () {
        if (qtyInput.value > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
        }
    };

    let printButton = document.createElement("button");
    printButton.innerText = "Print";
    printButton.style.padding = "5px 10px";
    printButton.style.border = "1px solid Gray";
    printButton.onclick = function () {
        let copies = parseInt(qtyInput.value);
        printQrCode(qrCode, studentInfo, copies);
    };

    printControls.appendChild(minusButton);
    printControls.appendChild(qtyInput);
    printControls.appendChild(plusButton);
    printControls.appendChild(printButton);

    qrContainer.appendChild(qrCode);
    qrContainer.appendChild(studentInfo);
    qrContainer.appendChild(printControls);

    qrDiv.appendChild(qrContainer);
}


function closeQrPopup() {
    document.getElementById("qr-code-response-overlayer").style.display = "none";
    document.getElementById("qr-code-response").innerHTML = "";
}
//
function showSelectedQr() {
    let qrDiv = document.getElementById("qr-code-response");
    let overlay = document.getElementById("qr-code-response-overlayer");

    qrDiv.innerHTML = "";

    let selectedStudents = document.querySelectorAll(".selectForQrCode:checked");

    if (selectedStudents.length === 0) {
        alert("Please select at least one student.");
        return;
    }

    overlay.style.display = "block";

    qrDiv.style.display = "grid";
    qrDiv.style.gridTemplateColumns = "repeat(auto-fill, minmax(200px, 1fr))";
    qrDiv.style.gap = "10px";
    qrDiv.style.justifyContent = "center";
    qrDiv.style.alignItems = "center";

    selectedStudents.forEach(checkbox => {
        let studentData = checkbox.value;
        let student = studentData.split("#");
        let studentId = student[0];
        let studentName = student[1];
        let studentClass = student[0];
        let qrContainer = document.createElement("div");
        qrContainer.classList.add("p-2");
        qrContainer.style.textAlign = "center";
        qrContainer.style.width = "200px";
        qrContainer.style.height = "200px";
        qrContainer.style.marginTop = "10px";


        qrDiv.appendChild(qrContainer);

        new QRCode(qrContainer, {
            text: `http://127.0.0.1:8000/School/showQrCode/${studentId}`,
            width: 200,
            height: 200
        });
        let studentInfo = document.createElement("div");
        studentInfo.style.textAlign = "center";
        studentInfo.style.marginTop = "2px";
        studentInfo.style.fontSize = "1em";
        studentInfo.style.fontWeight = "500";
        studentInfo.innerHTML = `${studentName} Class -${studentClass}`;
        qrContainer.appendChild
        qrContainer.appendChild(studentInfo);
    });
}
//
function selectAllChecklist(element) {
    if (element.checked == false) {
        let students = document.querySelectorAll(".selectForQrCode");
        students.forEach(student => {
            student.checked = false;
        });
        closeQrPopup()
    } else {
        let students = document.querySelectorAll(".selectForQrCode");
        students.forEach(student => {
            student.checked = true;
        });
        showSelectedQr();
    }
}
function printQrCode(qrCode, studentInfo, copies) {
    let printWindow = window.open("", "", "width=600,height=600");
    let content = "";

    for (let i = 0; i < copies; i++) {
        content += `
            <div style="text-align: center; margin-bottom: 20px;">
                ${qrCode.innerHTML}
                <br>
                <div style="font-size: 1.2em; font-weight: 500;">${studentInfo.innerHTML}</div>
            </div>
        `;
    }

    printWindow.document.write(`
        <html>
        <head><title>Print QR Code</title></head>
        <body style="text-align: center;">
            ${content}
            <script>
                window.onload = function() {
                    window.print();
                    window.close();
                };
            </script>
        </body>
        </html>
    `);
    printWindow.document.close();
}