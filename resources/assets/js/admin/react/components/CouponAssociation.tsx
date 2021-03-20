import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import swal from 'sweetalert2';
import ReactSelect from 'react-select';
import Animated from 'react-select/animated';

class CouponAssociation extends React.Component<any, any> {
  state = {
    types: [],
    products: [],
    subtypes: [],
    couponTypes: [],
    couponProducts: [],
    couponSubtypes: [],
    tsubtypes: [],
  };

  getData = async () => {
    const dataTypes = await axios.get('/ajax-admin/types').catch(console.warn);
    const dataProducts = await axios.get('/ajax-admin/products').catch(console.warn);
    const dataSubtypes = await axios.get('/ajax-admin/subtypes').catch(console.warn);
    const responseCoupon = await axios
      .get(`/ajax-admin/coupons/${this.props.couponId}`)
      .catch(console.warn);
    const products = dataProducts['data']['data'];
    const subtypes = dataSubtypes['data']['data'];
    const types = dataTypes['data']['data'];
    const coupon = responseCoupon['data']['data'];
    const selectedProducts =
      coupon['products'].length && products.length
        ? products
            .filter(product => coupon['products'].includes(product['id']))
            .map(this.mapProduct)
        : [];
    const selectedSubtypes =
      coupon['product_subtypes'].length && subtypes.length
        ? subtypes
            .filter(subtype => coupon['product_subtypes'].includes(subtype['id']))
            .map(this.mapSubtype)
        : [];
    const selectedTypes =
      coupon['product_types'].length && types.length
        ? types.filter(type => coupon['product_types'].includes(type['id'])).map(this.mapType)
        : [];

    this.setState({
      subtypes,
      types,
      products,
      couponProducts: selectedProducts,
      couponTypes: selectedTypes,
      couponSubtypes: selectedSubtypes,
      tsubtypes: subtypes,
    });
  };

  handleUpdateSubtype = values => this.setState({ couponSubtypes: values });

  handleUpdateType = (values) => {

    this.setState({ couponTypes: values })

    let tmp_subtypes = this.state.tsubtypes;
    tmp_subtypes = tmp_subtypes.filter((c) => { return c.type_id === values.value})
    this.setState({ subtypes: tmp_subtypes });

    };

  handleUpdateProducts = values => this.setState({ couponProducts: values });

  handleSaveChanges = async () => {
    const content = {
      types: this.state.couponTypes,
      products: this.state.couponProducts,
      subtypes: this.state.couponSubtypes,
    };
    const response = await axios
      .post(`/ajax-admin/coupons/${this.props.couponId}/types-subtypes`, content)
      .catch(console.warn);

    if (response['data']) {
      this.getData();
      swal({
        title: 'Guardado',
        type: 'success',
        toast: true,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
      });
    }
  };

  mapProduct = product => {
    return {
      value: product['id'],
      label: `${product['fullname']} - PEN: ${product['price']} / USD: ${product['price_dolar']}`,
    };
  };

  mapSubtype = subtype => ({ value: subtype['id'], label: subtype['name'] });

  mapType = type => ({ value: type['id'], label: type['name'] });

  componentDidMount() {
    this.getData();
  }

  render() {
    const optionTypes = this.state.types.length ? this.state.types.map(this.mapType) : [];
    const optionProducts = this.state.products.length
      ? this.state.products.map(this.mapProduct)
      : [];
    let optionSubtypes = this.state.subtypes.length
      ? this.state.subtypes.map(this.mapSubtype)
      : [];

    return (
      <div className="card">
        <div className="card-body">
          <div className="row">
            <div className="col-md">
              <div className="form-group">
                <label>Tipos</label>
                <ReactSelect
                  components={Animated}
                  options={optionTypes}
                  onChange={this.handleUpdateType}
                  value={this.state.couponTypes}
                  isMulti={false}
                  closeMenuOnSelect={false}
                />
              </div>
            </div>
            <div className="col-md">
              <div className="form-group">
                <label>Subtipos</label>
                <ReactSelect
                  components={Animated}
                  options={optionSubtypes}
                  onChange={this.handleUpdateSubtype}
                  value={this.state.couponSubtypes}
                  isMulti={true}
                  closeMenuOnSelect={false}
                />
              </div>
            </div>
            <div className="col-md">
              <div className="form-group">
                <label>Productos</label>
                <ReactSelect
                  components={Animated}
                  options={optionProducts}
                  onChange={this.handleUpdateProducts}
                  value={this.state.couponProducts}
                  isMulti
                  closeMenuOnSelect={false}
                />
              </div>
            </div>
          </div>
          <button onClick={this.handleSaveChanges} className="btn btn-dark btn-rounded">
            Guardar
          </button>
        </div>
      </div>
    );
  }
}

if (document.getElementById('bipolar-coupon-association')) {
  const productId = (window as any).BipolarCouponId;
  ReactDOM.render(
    <CouponAssociation couponId={productId} />,
    document.getElementById('bipolar-coupon-association')
  );
}
