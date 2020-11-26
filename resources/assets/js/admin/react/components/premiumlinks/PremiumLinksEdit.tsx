import React, { Fragment } from 'react';
import ReactDOM from 'react-dom';
import ReactSelect from 'react-select';
import Animated from 'react-select/animated';
import moment from 'moment';
import Datetime from 'react-datetime';
import swal from 'sweetalert2';
import 'react-datetime/css/react-datetime.css';
import { IPremiumLink } from '@interfaces/IPremiumLink';
import GraphqlAdmin from '../../../graphql-admin';
import { gql } from 'apollo-boost';
import { IProduct } from '@interfaces/IProduct';

class PremiumLinksEdit extends React.Component<any> {
  state = {
    showErrorMessage: false,
    // data from ajax
    productsCopy: [],
    products: [],
    selectedProducts: [],
    // form data
    name: '',
    end: moment().format('DD/MM/YYYY'),
  };

  handleUpdateProducts = values => this.setState({ selectedProducts: values });

  handleChangeEndDate = date => {
    this.setState({ end: date.format('DD/MM/YYYY') });
  };

  handleNameChange = event => this.setState({ name: event.target.value });

  messageValidate( message, type) {
    swal({
      title: message,
      type: type,
      toast: false,
      position: 'center',
      showConfirmButton: true,
    });
  }

  Validate(val) { 
    if (val === '' || val.length <= 0 || val.trim() === '') {
    
      return false;
    } else {
      return true;
    
    }
  
  }

  handleSavePremiumLink = async event => {

    event.preventDefault();
    //const selectedProducts = this.state.selectedProducts;

    if (!(this.Validate(this.state.name))) {
      
      this.messageValidate('Debe Ingresar un Nombre Descriptivo', 'warning');
      return false;
    }

    
    let variables: {} = {
      name: this.state.name,
      uuid : this.props.taskId,
      end: this.state.end,
    };

    if (this.state.selectedProducts.length) {
      variables = {
        ...variables,
        products: this.state.selectedProducts.map(option => option.value),
      };
    }

    swal({
      title: 'Procesando ...',
      toast: true,
      position: 'top-right',
      showConfirmButton: false,
      onOpen: () => swal.showLoading(),
    });


    await GraphqlAdmin.mutation(
      gql`
        mutation PremiumLinkUpdation(
          $uuid: String!
          $name: String!
          $end: String!
          $products: [String]
        ) {
          premium_link_updation(
            uuid: $uuid
            name: $name
            end: $end
            products: $products
          ) {
            name
          }
        }
      `,
      variables
    )
      .catch(console.warn)
      .then(() => {
        //this.clean();
      
        swal.close();
       
      }).finally(() => {
        this.messageValidate('Datos Actualizados correctamente.', 'success');
      });
    
  };

  getPremiumLink = async () => {
    // @ts-ignore
    let variables: {} = {
      uuid: this.props.taskId,
    };

    swal({
      title: 'Obteniendo Información...',
      toast: true,
      position: 'top-right',
      showConfirmButton: false,
      onOpen: () => swal.showLoading(),
    });


    const { data } = await GraphqlAdmin.query_parameters<{ premium_links: IPremiumLink[]}>(
      gql`
      query getPremiumLink($uuid: String){
        premium_links(uuid: $uuid){
            uuid
            hash_id
            name
            end
            edit_route
            preview_route
            available
            products
            products_model {
              hash_id
              price_pen
              price_usd
              fullname
            }
          }
      }
    `, { uuid: this.props.taskId }
    );

    swal.close();

   if (Array.isArray(data.premium_links)) {
     this.setState({ name: data.premium_links[0].name });
     this.setState({ end: moment(data.premium_links[0].end).format('DD/MM/YYYY') });

     const selectedProducts = data.premium_links[0].products_model.map(product => {
      return {
        value: product.hash_id,
        label: `${product.fullname} - PEN: ${product.price_pen} / USD: ${product.price_usd}`,
      };
    })

     this.setState({ selectedProducts: selectedProducts });

     
   } else {
     this.setState({ readOnly: true });

     swal({
       title: 'Ha ocurrido un Error en la Obtencion de los Datos. Comuníquese con Soporte.',
       type: 'error',
       toast: true,
       position: 'center',
       showConfirmButton: false,
       timer: 5000,
     });

    }
  };

  getProducts = async () => {
    const { data } = await GraphqlAdmin.query<{ products: IProduct[] }>(gql`
      query {
        products {
          hash_id
          fullname
          price_pen
          price_usd
          colors {
            name
          }
        }
      }
    `);
    this.setState({ products: [...data.products], productsCopy: [...data.products] });
  };

  componentDidMount() {
    this.getProducts();
    this.getPremiumLink();
  }


  mapProducts = product => ({
    value: product['id'],
    label: `${product['fullname']} - PEN: ${product['price']} / USD: ${product['price_dolar']}`,
  });

  render() {
    
      const optionProducts = this.state.productsCopy.length
      ? this.state.productsCopy.map(product => {
          return {
            value: product.hash_id,
            label: `${product.fullname} - PEN: ${product.price_pen} / USD: ${product.price_usd}`,
          };
        })
      : [];
    
  

    const errorMessage = this.state.showErrorMessage ? (
      <div className="alert alert-danger">Por favor llene todos los campos necesarios</div>
    ) : null;

    return (
      <Fragment>
         <div className="card">
          <div className="card-body">
            {errorMessage}
            <form onSubmit={this.handleSavePremiumLink}>
              <div className="row">
                <div className="col-md">
                  <div className="form-group">
                      <label>Nombre descriptivo</label>
                      <input
                        type="text"
                        onChange={this.handleNameChange}
                        value={this.state.name}
                        className="form-control"
                        placeholder="Ej: Enlace Premium Cyber Day"
                        maxLength={250}
                        required
                      />
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Fecha Límite </label>
                    <Datetime
                      dateFormat="DD/MM/YYYY"
                      onChange={this.handleChangeEndDate}
                      timeFormat={false}
                      defaultValue={this.state.end}
                      value={this.state.end}
                    />
                  </div>
                </div>
              </div>
              <div className="row">
                <div className="col-md">
                  <div className="form-group">
                    <label>Aplicar a productos</label>
                    <ReactSelect
                      components={Animated}
                      onChange={this.handleUpdateProducts}
                      value={this.state.selectedProducts}
                      options={optionProducts}
                      isMulti
                      closeMenuOnSelect={false}
                    />
                  </div>
                </div>
              </div>
              <button type="submit" className="btn btn-sm btn-dark btn-rounded">
                Editar Enlace Premium
              </button>
            </form>
          </div>
        </div>
      </Fragment>
    );
  }
}

if (document.getElementById('bipolar-product-premium-link-edit')) {
  const BipolarLinkPremiumUuid = (window as any).BipolarPremiumLinkUuid;
  ReactDOM.render(
    <PremiumLinksEdit taskId={BipolarLinkPremiumUuid} />,
    document.getElementById('bipolar-product-premium-link-edit')
  );
}
