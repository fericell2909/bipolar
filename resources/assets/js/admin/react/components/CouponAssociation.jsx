import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import * as swal from "sweetalert2";
import ReactSelect from "react-select";
import "react-select/dist/react-select.css";

class CouponAssociation extends React.Component {

  state = {
    types: [],
    products: [],
    couponTypes: [],
    couponProducts: [],
  };

  getData = async () => {
    const dataTypes = await axios.get('/ajax-admin/types').catch(console.warn);
    const dataProducts = await axios.get('/ajax-admin/products').catch(console.warn);
    const responseCoupon = await axios.get(`/ajax-admin/coupons/${this.props.couponId}`).catch(console.warn);
    const coupon = responseCoupon['data']['data'];
    this.setState({
      types: dataTypes['data']['data'],
      products: dataProducts['data']['data'],
      couponProducts: coupon['products'],
      couponTypes: coupon['product_types'],
    });
  };

  handleUpdateType = values => {
    const optionsSelected = values.map(value => value['value']);
    this.setState({couponTypes: optionsSelected});
  };

  handleUpdateProducts = values => {
    const optionsSelected = values.map(value => value['value']);
    this.setState({couponProducts: optionsSelected});
  };

  handleSaveChanges = async () => {
    const content = {
      types: this.state.couponTypes,
      products: this.state.couponProducts,
    };
    const response = await axios.post(`/ajax-admin/coupons/${this.props.couponId}/types-subtypes`, content).catch(console.warn);

    if (response['data']) {
      this.getData();
      swal({
        title: "Guardado",
        type: "success",
        toast: true,
        position: "top-right",
        showConfirmButton: false,
        timer: 3000
      });
    }
  };

  componentDidMount() {
    this.getData();
  }

  render() {
    const optionTypes = this.state.types.length ? this.state.types.map(type => {
      return {value: type['id'], label: type["name"]};
    }) : null;
    const optionProducts = this.state.products.length ? this.state.products.map(product => {
      return {value: product['id'], label: product["name"]};
    }) : null;

    return (
      <div className="card">
        <div className="card-body">
          <div className="row">
            <div className="col-md">
              <div className="form-group">
                <label>Tipos</label>
                <ReactSelect options={optionTypes} onChange={this.handleUpdateType} value={this.state.couponTypes} multi closeOnSelect={false}/>
              </div>
            </div>
            <div className="col-md">
              <div className="form-group">
                <label>Productos</label>
                <ReactSelect options={optionProducts} onChange={this.handleUpdateProducts} value={this.state.couponProducts} multi closeOnSelect={false}/>
              </div>
            </div>
          </div>
          <button onClick={this.handleSaveChanges} className="btn btn-dark btn-rounded">Guardar</button>
        </div>
      </div>
    );
  }
}

if (document.getElementById('bipolar-coupon-association')) {
  const productId = window.BipolarCouponId;
  ReactDOM.render(<CouponAssociation couponId={productId}/>, document.getElementById('bipolar-coupon-association'));
}