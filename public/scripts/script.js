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