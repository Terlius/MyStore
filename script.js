const productsContainer = document.querySelector(".products");
const epaycoContainer = document.getElementById("epaycoCheckoutContainer");

function generateEpaycoButton(button) {
  const product = button.closest(".product");
  if (product) {
    const name = product.dataset.name;
    const description = product.dataset.description;
    const value = product.dataset.value;
    const iva = product.dataset.iva;

    selectedProductName.textContent = name;
    selectedProductDescription.textContent = description;
    selectedProductValue.textContent = value;
    selectedProductIVA.textContent = product.dataset.iva;

    // Elimina cualquier botón de ePayco existente
    const existingButton = epaycoContainer.querySelector(".epayco-button");

    if (existingButton !== null) {
      existingButton.remove();
      const epaycoButtonRender = document.querySelector(
        ".epayco-button-render"
      );
      if (epaycoButtonRender !== null) {
        epaycoButtonRender.remove();
      }
    }

    // Crea un nuevo botón de ePayco
    const epaycoButton = document.createElement("script");
    epaycoButton.src = "https://checkout.epayco.co/checkout.js";
    epaycoButton.classList.add("epayco-button");
    epaycoButton.setAttribute(
      "data-epayco-key",
      "491d6a0b6e992cf924edd8d3d088aff1"
    );
    epaycoButton.setAttribute("data-epayco-currency", "cop");
    epaycoButton.setAttribute("data-epayco-country", "co");
    epaycoButton.setAttribute("data-epayco-test", "true");
    epaycoButton.setAttribute("data-epayco-external", "false");
    epaycoButton.setAttribute(
      "data-epayco-response",
      "http://localhost/Daniela/response.html"
    );
    epaycoButton.setAttribute(
      "data-epayco-confirmation",
      "http://localhost/Daniela/confirmation.php"
    );
    epaycoButton.setAttribute("data-epayco-methodconfirmation", "get");
    epaycoButton.setAttribute("data-epayco-name", name);
    epaycoButton.setAttribute("data-epayco-amount", value);
    
    epaycoButton.setAttribute("tax", iva);
    epaycoButton.setAttribute("data-epayco-description", description);
  

    typedoc = document.getElementById("userTypeDoc").textContent?? "CC";
    numberdoc = document.getElementById("userNumberDoc").textContent ?? "";
    username = document.getElementById("userName").textContent ?? "";
    //Datos cliente
    epaycoButton.setAttribute("type_doc_billing", typedoc);
    epaycoButton.setAttribute("number_doc_billing", numberdoc);
    epaycoButton.setAttribute("name_billing", username);

    // Adjunta el botón de ePayco al contenedor
    epaycoContainer.appendChild(epaycoButton);

    // Muestra el botón de ePayco
    epaycoButton.style.display = "block";
  }


}

function cambiarDatosUser(element) {
    const username = element.getAttribute("data-username");
    const typedoc = element.getAttribute("data-typedoc");
    const numberdoc = element.getAttribute("data-numberdoc");
    console.log(element)

    document.getElementById("userName").textContent = username;
    document.getElementById("userTypeDoc").textContent = typedoc;
    document.getElementById("userNumberDoc").textContent = numberdoc;
    console.log(username, typedoc, numberdoc)
  }