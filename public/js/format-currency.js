function formatCurrency(input) {
    let value = input.value.replace(/\D/g, "");

    if (value === "") {
        input.value = "";
        return;
    }

    input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
