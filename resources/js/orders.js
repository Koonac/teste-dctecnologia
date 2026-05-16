document.addEventListener("DOMContentLoaded", function () {
    // Variáveis globais
    const orderProducts = window.orderProducts; // array de produtos
    let productsSelected = [];

    // Elementos do formulário
    const productsJson = document.getElementById("products_json");
    const productId = document.getElementById("product_id");
    const quantity = document.getElementById("quantity");
    const price = document.getElementById("price");
    const paymentMethod = document.getElementById("payment_method");
    const installmentCount = document.getElementById("installment_count");
    const addProductButton = document.getElementById("add_product_button");
    const addPaymentButton = document.getElementById("add_payment_button");
    const totalOrder = document.getElementById("total_order");

    /*************** FUNÇÕES ***************/
    function formatReal(valor) {
        return new Intl.NumberFormat("pt-BR", {
            style: "currency",
            currency: "BRL",
        }).format(valor);
    }

    // Selecionar produto
    function selectProduct() {
        const product = orderProducts.find(
            (product) => product.id == productId.value,
        );
        if (product) {
            quantity.value = 1;
            price.value = product.price;
        } else {
            quantity.value = null;
            price.value = null;
        }
    }

    // reset valores produtos
    function resetProductValues() {
        productId.value = "";
        quantity.value = null;
        price.value = null;
    }

    // adicionar produto ao formulário
    function addProductToForm() {
        productsSelected.push({
            productId: productId.value,
            quantity: quantity.value,
            price: price.value,
        });

        productsJson.value = JSON.stringify(productsSelected);
    }

    //remover produto do formulário
    function removeProductFromForm(productIndex) {
        productsSelected = productsSelected.filter(
            (product, index) => index != productIndex,
        );
        productsJson.value = JSON.stringify(productsSelected);
        calculateTotalOrderAndUpdateUI();
        updateProductsTable();
    }

    // calcular total do pedido
    function calculateTotalOrderAndUpdateUI() {
        let totalPedido = 0;
        productsSelected.forEach((product) => {
            let totalProduct = product.price * product.quantity;
            totalPedido += totalProduct;
        });
        totalOrder.textContent = formatReal(totalPedido);
    }

    // atualizar tabela de produtos
    function updateProductsTable() {
        const productsTable = document.getElementById("products_table");
        productsTable.innerHTML = "";
        productsSelected.forEach((p, index) => {
            const product = orderProducts.find((p2) => p2.id == p.productId);

            const tr = document.createElement("tr");
            tr.className = "hover:bg-gray-100";
            tr.innerHTML = `
            <td class="text-left p-2">${product.name}</td>
            <td class="text-center p-2">${p.quantity}</td>
            <td class="text-right p-2">${formatReal(p.price)}</td>
            <td class="text-center p-2">
                <button type="button" class="text-red-500 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="currentColor" d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z" />
                    </svg>
                </button>
            </td>`;

            tr.querySelector("button").addEventListener("click", () => {
                removeProductFromForm(index);
            });

            productsTable.appendChild(tr);
        });
    }
    /*************** EVENTOS ***************/

    // Evento de seleção de produto
    productId.addEventListener("change", function () {
        selectProduct();
    });

    // Adicionar produto ao formulário
    addProductButton.addEventListener("click", function () {
        addProductToForm();
        calculateTotalOrderAndUpdateUI();
        resetProductValues();
        updateProductsTable();
    });

    // Adicionar pagamento ao formulário
    paymentMethod.addEventListener("change", function () {
        if (paymentMethod.value == "installment") {
            installmentCount.style.display = "block";
        } else {
            installmentCount.style.display = "none";
        }
    });

    // Adicionar pagamento ao formulário
    addPaymentButton.addEventListener("click", function () {
        // TODO: Adicionar pagamento ao formulário
        // TODO: Calcular total do pedido
        // TODO: Resetar valores do pagamento
        // TODO: Atualizar tabela de pagamentos
        // TODO: Adicionar botão de remover pagamento
        // TODO: Adicionar botão de editar pagamento
    });
});
