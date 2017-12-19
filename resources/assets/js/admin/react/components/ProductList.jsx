import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import get from "lodash/get";
import swal from "sweetalert2";
import { existInArray, removeFromSimpleArray } from "../helpers";
import ProductRow from "./partials/ProductRow";

export default class BipolarProductList extends React.Component {
  constructor() {
    super();
    this.state = {
      products: [],
      filteredProducts: [],
      searchText: "",
      selectedProducts: [],
      selectedMassiveAction: "",
      // Filter selects
      statesForSelect: [],
      stateSelected: "",
      typesForSelect: [],
      typeSelected: "",
      creationDates: [],
      creationDateSelected: "",
      months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
      years: ["2016", "2017"],
    };

    this.handleSearch = this.handleSearch.bind(this);
    this.handleProductSelect = this.handleProductSelect.bind(this);
    this.handleSelectAllProducts = this.handleSelectAllProducts.bind(this);
    this.handleMassiveSelection = this.handleMassiveSelection.bind(this);
  }

  handleDelete(productHashId) {
    swal({
      type: "warning",
      title: "¿Desea descartar el producto?",
      text: "El producto se pondrá en la lista de descartados",
      confirmButtonText: "Sí, descartar",
      showCancelButton: true,
      cancelButtonText: "No hacer nada"
    }).then(result => {
      if (result.value) {
        swal.showLoading();
        axios.delete(`/ajax-admin/products/${productHashId}`).then(() => {
          swal({
            title: "Descartado",
            type: "success",
            toast: true,
            position: "top-right",
            showConfirmButton: false,
            timer: 3000
          });
          this.getAllProducts();
        });
      }
    });
  }

  handleSearch(event) {
    const searchText = event.target.value;
    const filteredProducts = this.state.products.filter(product => {
      return product.name.search(searchText) !== -1;
    });

    this.setState({ searchText, filteredProducts });
  }

  handleProductSelect(event) {
    const productHashId = event.target.value;
    let selected = this.state.selectedProducts;

    if (event.target.checked) {
      selected.push(productHashId);
    } else {
      selected = removeFromSimpleArray(selected, productHashId);
    }

    return this.setState({ selectedProducts: selected });
  }

  handleSelectAllProducts(event) {
    let allProductsIds = [];

    if (event.target.checked) {
      allProductsIds = this.state.products.map(product => product["hash_id"]);
    }

    this.setState({ selectedProducts: [...allProductsIds] });
  }

  handleMassiveSelection(event) {
    const optionSelected = event.target.value;

    if (this.state.selectedProducts.length === 0) {
      return swal(
        "Error",
        "Seleccione un producto o más para continuar",
        "error"
      );
    }

    return swal({
      title: "Atención",
      text: `Se cambiará el estado de todos los ${
        this.state.selectedProducts.length
      } productos seleccionados`,
      type: "warning",
      confirmButtonText: "Sí, cambiar",
      showCancelButton: true,
      cancelButtonText: "No hacer nada"
    }).then(result => {
      if (result.value) {
        const products = this.state.selectedProducts;

        switch (optionSelected) {
          case "change_published": {
            axios
              .post("/ajax-admin/products/state/published", { products })
              .then(this.getAllProducts);
            break;
          }
          case "change_draft": {
            axios
              .post("/ajax-admin/products/state/draft", { products })
              .then(this.getAllProducts);
            break;
          }
          case "change_pending": {
            axios
              .post("/ajax-admin/products/state/pending", { products })
              .then(this.getAllProducts);
            break;
          }
          case "activate_salient": {
            axios
              .post("/ajax-admin/products/salient/1", { products })
              .then(this.getAllProducts);
            break;
          }
          case "deactivate_salient": {
            axios
              .post("/ajax-admin/products/salient/0", { products })
              .then(this.getAllProducts);
            break;
          }
          case "activate_free": {
            axios
              .post("/ajax-admin/products/freeshipping/1", { products })
              .then(this.getAllProducts);
            break;
          }
          case "deactivate_free": {
            axios
              .post("/ajax-admin/products/freeshipping/0", { products })
              .then(this.getAllProducts);
            break;
          }
          case "dolar_price": {
            axios
              .post("/ajax-admin/products/dolar-price", { products })
              .then(this.getAllProducts);
            break;
          }
        }

        swal({
          title: "Hecho",
          type: "success",
          toast: true,
          position: "top-right",
          showConfirmButton: false,
          timer: 5000
        });
        this.setState({ selectedProducts: [] });
      }
    });
  }

  render() {
    const productsSource =
      this.state.searchText.length > 0
        ? [...this.state.filteredProducts]
        : [...this.state.products];

    const subtypes = this.state.typesForSelect.map(type => {
      return type.subtypes.map(subtype => {
        return (
          <option key={subtype["hash_id"]} value={subtype["hash_id"]}>
            {subtype["name"]}
          </option>
        );
      });
    });

    const productsRender = productsSource.map(product => {
      return (
        <ProductRow
          key={product["hash_id"]}
          selectedProducts={this.state.selectedProducts}
          hashId={product["hash_id"]}
          imageUrl={product["firstImageUrl"]}
          name={product["name"]}
          subtypes={product["subtypes"]}
          price={product["price"]}
          priceDolar={product["price_dolar"]}
          state={product["state"]}
          freeShipping={product["free_shipping"]}
          isSalient={product["is_salient"]}
          previewUrl={product["preview_route"]}
          clickDelete={this.handleDelete}
          clickProductSelect={this.handleProductSelect}
        />
      );
    });

    return (
      <div className="row">
        <div className="col-md-12">
          <div className="white-box">
            <div className="row">
              <div className="col-md-11">
                <h3 className="box-title">Listar los productos</h3>
              </div>
              <div className="col-md-1">
                <a
                  href="/admin/products/new"
                  className="btn btn-dark btn-rounded"
                >
                  <i className="fa fa-plus" /> Nuevo
                </a>
              </div>
            </div>
            <div className="row">
              <div className="col-md-9">
                <div className="form-group">
                  <label>Buscar producto</label>
                  <input
                    value={this.state.searchText}
                    onChange={this.handleSearch}
                    type="text"
                    className="form-control"
                  />
                </div>
              </div>
              <div className="col-md-3">
                <div className="form-group">
                  <label>Acciones (pendiente)</label>
                  <select
                    value={this.state.selectedMassiveAction}
                    onChange={this.handleMassiveSelection}
                    className="custom-select col-12"
                  >
                    <option value="" disabled>
                      Seleccione
                    </option>
                    <optgroup label="Estado publicación">
                      <option value="change_published">
                        Cambiar a activo (Publicado)
                      </option>
                      <option value="change_draft">Cambiar a borrador</option>
                      <option value="change_pending">
                        Cambiar a pendiente de revisión
                      </option>
                    </optgroup>
                    <optgroup label="Destacado">
                      <option value="activate_salient">
                        Activar destacado
                      </option>
                      <option value="deactivate_salient">
                        Desactivar destacado
                      </option>
                    </optgroup>
                    <optgroup label="Envío gratuito">
                      <option value="activate_free">
                        Activar envío gratuito
                      </option>
                      <option value="deactivate_free">
                        Desactivar envío gratuito
                      </option>
                    </optgroup>
                    <optgroup label="Precio">
                      <option value="dolar_price">
                        Asignar precio en dólares
                      </option>
                    </optgroup>
                  </select>
                </div>
              </div>
            </div>
            <div className="row">
              <div className="col-md-3">
                <div className="form-group">
                  <label>Filtrar por estado publicación</label>
                  <select value={this.state.stateSelected} className="custom-select col-12">
                    <option value="" disabled>Seleccione</option>
                    {this.state.statesForSelect.map(state => {
                      return <option key={state.hash_id} value={state.hash_id}>{state.name}</option>
                    })}
                  </select>
                </div>
              </div>
              <div className="col-md-3">
                <div className="form-group">
                  <label>Filtrar por tipo</label>
                  <select value={this.state.typeSelected} className="custom-select col-12">
                    <option value="" disabled>Seleccione</option>
                    {subtypes}
                  </select>
                </div>
              </div>
              <div className="col-md-3">
                <div className="form-group">
                  <label>Filtrar por fecha de creación</label>
                  <select value={this.state.creationDateSelected} className="custom-select col-12">
                    <option value="" disabled>Seleccione</option>
                    {this.state.creationDates.map(creationDate => {
                      return (
                        <option key={creationDate.value} value={creationDate.value}>
                          {creationDate.name}
                        </option>
                      );
                    })}
                  </select>
                </div>
              </div>
            </div>
            <table className="table">
              <thead>
                <tr>
                  <th>
                    <input
                      type="checkbox"
                      checked={
                        this.state.products.length ===
                        this.state.selectedProducts.length
                      }
                      onChange={this.handleSelectAllProducts}
                    />
                  </th>
                  <th>#</th>
                  <th>
                    <i className="fa fa-photo" />
                  </th>
                  <th>Nombre</th>
                  <th>Tipos</th>
                  <th className="text-right">Precio (S/)</th>
                  <th className="text-right">Precio ($)</th>
                  <th className="text-center">Estado</th>
                  <th className="text-center">Envío gratis</th>
                  <th className="text-center">Destacado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>{productsRender.length ? productsRender : null}</tbody>
            </table>
          </div>
        </div>
      </div>
    );
  }

  copyProductsToState = responseProducts => {
    const products = responseProducts.data["data"];
    const formattedProducts = products.map(product => {
      return {
        ...product,
        firstImageUrl: get(product, "photos.0.url", null)
      };
    });
    
    return this.setState({ products: formattedProducts });
  }

  getAllProducts() {
    axios.get("/ajax-admin/products").then(this.copyProductsToState);
  }

  componentDidMount() {
    const creationDates = [];
    for (let indexYear = 0; indexYear < this.state.years.length; indexYear++) {
      for (let indexMonth = 0; indexMonth < this.state.months.length; indexMonth++) {
        creationDates.push({
          value: `${indexMonth+1}-${this.state.years[indexYear]}`,
          name: `${this.state.months[indexMonth]} ${this.state.years[indexYear]}`,
        });
      }
    }

    return axios.all([
      axios.get("/ajax-admin/products"),
      axios.get("/ajax-admin/states"),
      axios.get("/ajax-admin/types"),
    ]).then(axios.spread((responseProducts, responseStates, responseTypes) => {
      this.copyProductsToState(responseProducts);
      this.setState({ 
        statesForSelect: responseStates.data["data"],
        typesForSelect: responseTypes.data["data"],
        creationDates,
      });
    }));
  }
}

if (document.getElementById("bipolar-product-list")) {
  ReactDOM.render(
    <BipolarProductList />,
    document.getElementById("bipolar-product-list")
  );
}
