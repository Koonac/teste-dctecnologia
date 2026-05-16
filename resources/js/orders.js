document.addEventListener("DOMContentLoaded", function () {
    // Variáveis globais
    const orderProducts = window.orderProducts; // array de produtos
    let productsSelected = [];
    let paymentsSelected = [];
    let totalPedido = 0;

    // Elementos do formulário
    const productsJson = document.getElementById("products_json");
    const paymentsJson = document.getElementById("payments_json");
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
        totalPedido = 0;
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
            <td class="text-right p-2">${formatReal(p.price * p.quantity)}</td>
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

    // Resetar valores do pagamento
    function resetPaymentValues() {
        paymentMethod.value = "";
        installmentCount.value = null;
    }

    // Adicionar pagamento ao formulário
    function addPaymentToForm() {
        if (paymentMethod.value == "installment") {
            let dueDate = new Date();
            let totalPedidoRestante = totalPedido;
            let qtdeParcelas = installmentCount.value;
            dueDate.setDate(dueDate.getDate() + 30);

            for (let i = 1; i <= qtdeParcelas; i++) {
                let valorParcela = parseFloat(
                    (totalPedido / qtdeParcelas).toFixed(2),
                );

                if (i == qtdeParcelas) {
                    valorParcela = parseFloat(totalPedidoRestante.toFixed(2));
                } else {
                    totalPedidoRestante -= valorParcela;
                }

                paymentsSelected.push({
                    paymentMethod: paymentMethod.value,
                    installment: i,
                    dueDate: dueDate.toISOString().split("T")[0],
                    value: valorParcela,
                });

                dueDate.setDate(dueDate.getDate() + 30);
            }
        } else {
            paymentsSelected.push({
                paymentMethod: paymentMethod.value,
                installment: 1,
                dueDate: "",
                value: totalPedido,
            });
        }
        paymentsJson.value = JSON.stringify(paymentsSelected);
    }

    // Remover pagamento do formulário
    function removePaymentFromForm(paymentIndex) {
        paymentsSelected = paymentsSelected.filter(
            (payment, index) => index != paymentIndex,
        );
        paymentsJson.value = JSON.stringify(paymentsSelected);
        updatePaymentsTable();
    }

    // Editar data de vencimento do pagamento
    function editPaymentDueDate(paymentIndex, dueDate) {
        paymentsSelected[paymentIndex].dueDate = dueDate;
        paymentsJson.value = JSON.stringify(paymentsSelected);
        updatePaymentsTable();
    }

    // Recalcular valores de pagamentos qualquer parcela
    function recalculatePaymentValuesAnyParcel(paymentIndex, value) {
        let newValue = Number(parseFloat(value).toFixed(2));
        let totalPedidoRestante = totalPedido;
        let valorParcela = 0;
        let qtdeParcelas = paymentsSelected.length;

        paymentsSelected.forEach((p, index) => {
            if (index < paymentIndex) {
                totalPedidoRestante -= p.value;
            } else if (index == paymentIndex) {
                p.value = newValue;
                totalPedidoRestante -= newValue;
            } else if (index > paymentIndex) {
                if (valorParcela == 0) {
                    valorParcela = parseFloat((totalPedidoRestante / (qtdeParcelas - index)).toFixed(2));
                }

                if (index == qtdeParcelas - 1) {
                    valorParcela = parseFloat(totalPedidoRestante.toFixed(2));
                } else {
                    totalPedidoRestante -= valorParcela;
                }

                p.value = valorParcela;
            }
        });

        paymentsJson.value = JSON.stringify(paymentsSelected);
    }

    // Recalcular valores de pagamentos ultima parcela
    function recalculatePaymentValuesLastParcel(paymentIndex, value) {
        let newValue = Number(parseFloat(value).toFixed(2));
        let totalPedidoRestante = totalPedido - newValue;
        let qtdeParcelas = paymentsSelected.length - 1;
        let valorParcela = parseFloat((totalPedidoRestante / qtdeParcelas).toFixed(2));

        paymentsSelected.forEach((p, index) => {
            if (index == paymentIndex) {
                p.value = newValue;
            } else {
                p.value = valorParcela;
                if (index == qtdeParcelas - 1) {
                    p.value = parseFloat(totalPedidoRestante.toFixed(2));
                }
                totalPedidoRestante -= valorParcela;
            }
        });

        paymentsJson.value = JSON.stringify(paymentsSelected);
    }

    // Editar valor do pagamento
    function editPaymentValue(paymentIndex, value) {
        const qtdeParcelas = paymentsSelected.length;
        (paymentIndex == qtdeParcelas - 1) 
            ? recalculatePaymentValuesLastParcel(paymentIndex, value) 
            : recalculatePaymentValuesAnyParcel(paymentIndex, value);
        updatePaymentsTable();
    }

    // Traduzir forma de pagamento
    function translatePaymentMethod(paymentMethod) {
        switch (paymentMethod) {
            case "cash":
                return "Dinheiro (à vista)";
            case "pix":
                return "Pix (à vista)";
            case "card":
                return "Cartão (à vista)";
            case "installment":
                return "Cartão (parcelado)";
        }
    }
    
    // Atualizar tabela de pagamentos
    function updatePaymentsTable() {
        const paymentsTable = document.getElementById("payments_table");
        paymentsTable.innerHTML = "";
        paymentsSelected.forEach((p, index) => {
            let inputDueDate = `<input type="date" class="w-full p-2 border border-gray-300 rounded-md" value="${p.dueDate}">`;
            let inputValue = `<input type="number" class="w-full p-2 border border-gray-300 rounded-md text-right" value="${p.value}" step="0.01">`;

            const tr = document.createElement("tr");
            tr.className = "hover:bg-gray-100";
            tr.innerHTML = `
            <td class="text-left p-2">${translatePaymentMethod(p.paymentMethod)}</td>
            <td class="text-center p-2">${p.installment}</td>
            <td class="text-center p-2">
                ${p.dueDate ? inputDueDate : "-"}
            </td>
            <td class="text-right p-2">
                ${inputValue}
            </td>
            <td class="text-center p-2">
                <button type="button" class="text-red-500 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="currentColor" d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z" />
                    </svg>
                </button>
            </td>`;

            tr.querySelector("button").addEventListener("click", () => {
                removePaymentFromForm(index);
            });

            if (p.dueDate) {
                tr.querySelector("input[type='date']").addEventListener(
                    "change",
                    () => {
                        editPaymentDueDate(
                            index,
                            tr.querySelector("input[type='date']").value,
                        );
                    },
                );
            }

            if (p.value) {
                tr.querySelector("input[type='number']").addEventListener(
                    "change",
                    () => {
                        editPaymentValue(
                            index,
                            tr.querySelector("input[type='number']").value,
                        );
                    },
                );
            }

            paymentsTable.appendChild(tr);
        });
    }
    /*************** EVENTOS ***************/

    // Evento de seleção de produto
    productId.addEventListener("change", function () {
        selectProduct();
    });

    // Adicionar produto ao formulário
    addProductButton.addEventListener("click", function () {
        if (productId.value == "") {
            alert("Selecione um produto para adicionar");
            return;
        }
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
        if (productsSelected.length == 0) {
            alert("Adicione pelo menos um produto para adicionar um pagamento");
            return;
        }
        if (paymentMethod.value == "") {
            alert("Selecione uma forma de pagamento para adicionar");
            return;
        }
        if (
            paymentMethod.value == "installment" &&
            installmentCount.value == ""
        ) {
            alert(
                "Informe a quantidade de parcelas para adicionar um pagamento parcelado",
            );
            return;
        }
        if (paymentsSelected.length > 0) {
            alert(
                "Já existe um pagamento adicionado, remova o pagamento atual para adicionar um novo",
            );
            return;
        }
        addPaymentToForm();
        resetPaymentValues();
        updatePaymentsTable();
        // TODO: Adicionar botão de editar pagamento
    });
});
