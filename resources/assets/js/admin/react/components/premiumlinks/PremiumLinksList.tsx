import React from 'react';
import swal from 'sweetalert2';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import axios from 'axios';
import {
  faCalendar,
  faEdit,
  faTrash,
} from '@fortawesome/free-solid-svg-icons';
import { IPremiumLink } from '@interfaces/IPremiumLink';

import GraphqlAdmin from '../../../graphql-admin';
import { gql } from 'apollo-boost';

interface Props {
  links: IPremiumLink[];
  onUpdateLinks: () => void;
}

export default class PremiumLinksList extends React.Component<Props, any> {
  toggleAvailability = (taskId: string, available: boolean) => {
    return swal({
      title: '¿Cambiar disponibilidad de la tarea?',
      text: 'Cambiarla a activa hará que esté disponible para ejecutarse automáticamente',
      showCancelButton: true,
      confirmButtonColor: '#000',
      cancelButtonColor: '#000',
      confirmButtonText: 'Sí, cambiar',
    }).then(async result => {
      if (result.value) {
        await axios.put(`/ajax-admin/discount-tasks/${taskId}`, { available }).catch(console.warn);
        swal({
          title: 'Actualizado',
          type: 'success',
          toast: true,
          position: 'top-right',
          showConfirmButton: false,
          timer: 3000,
        });
        this.props.onUpdateLinks();
      }
    });
  };

  executeTask = (taskId: string) => {
    return swal({
      title: '¿Ejecutar tarea?',
      text: 'Esta tarea se ejecutará ahora, se aplicarán descuentos a los productos',
      showCancelButton: true,
      confirmButtonColor: '#000',
      cancelButtonColor: '#000',
      confirmButtonText: 'Sí, ejecutar',
    }).then(async result => {
      if (result.value) {
        await axios.post(`/ajax-admin/discount-tasks/${taskId}/execute`).catch(console.warn);
        swal({
          title: 'Tarea ejecutada',
          type: 'success',
          toast: true,
          position: 'top-right',
          showConfirmButton: false,
          timer: 3000,
        });
        this.props.onUpdateLinks();
      }
    });
  };

  revertTask = (taskId: string) => {
    return swal({
      title: '¿Revertir tarea?',
      text: 'La reversión se ejecutará ahora, se removerán descuentos a los productos',
      showCancelButton: true,
      confirmButtonColor: '#000',
      cancelButtonColor: '#000',
      confirmButtonText: 'Sí, revertir',
    }).then(async result => {
      if (result.value) {
        await axios.post(`/ajax-admin/discount-tasks/${taskId}/revert`).catch(console.warn);
        swal({
          title: 'Tarea revertida',
          type: 'success',
          toast: true,
          position: 'top-right',
          showConfirmButton: false,
          timer: 3000,
        });
        this.props.onUpdateLinks();
      }
    });
  };

  deletePremiumLink = (premiumLinkId: string) => {
    return swal({
      title: '¿Desea Eliminar el Enlace Premium?',
      showCancelButton: true,
      confirmButtonColor: '#000',
      cancelButtonColor: '#000',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Sí, eliminar',
    }).then(async result => {
      if (result.value) {

        swal({
          title: 'Procesando ...',
          toast: true,
          position: 'top-right',
          showConfirmButton: false,
          onOpen: () => swal.showLoading(),
        });

        let variables: {} = {
          uuid: premiumLinkId,
        };

        await GraphqlAdmin.mutation(
          gql`
            mutation PremiumLinkDeletion(
              $uuid: String!
            ) {
              premium_link_deletion(
                uuid: $uuid
              ) {
                hash_id
              }
            }
          `,
          variables
        )
          .catch(() => {
            swal({
              title: 'Ha Ocurrido un Error. Por favor comuníquese con soporte.',
              type: 'error',
              toast: true,
              position: 'top-right',
              showConfirmButton: false,
              timer: 3000,
            });
          }
          )
          .then(() => {
            swal({
              title: 'Se Eliminó el Enlace Premium Correctamente.',
              type: 'success',
              toast: true,
              position: 'top-right',
              showConfirmButton: false,
              timer: 3000,
            });
          });
        
        this.props.onUpdateLinks();
      }
    });
  };

  render() {
    const links = this.props.links.map(link => {
      const products = (
        <ul className="row">
          {link.products_model?.map(product => (
            <li key={product.hash_id} className="col-sm-6">{product.fullname}</li>
          ))}
        </ul>
      );
      
     /*  let lblState;

      if (link.available) {

        lblState = (
          <>
            <span className="label label-success">Activo</span>
          </>
        );


      } else {
        lblState = (
          <>
            <span className="label label-danger">Inactivo</span>
          </>
        );
      } */

      return (
        <tr key={link.hash_id}>
          <td className="align-left">
            <span className="d-block font-16" style={{ fontWeight: 600 }}>
              {link.name}
            </span>
          </td>
          <td className="align-left">
            <div className="d-block text-black-50">
                <FontAwesomeIcon icon={faCalendar} />
                <span className="ml-2">
                  Hasta  {link.end}
                </span>
            </div>
          </td>
          <td className="align-middle w-25">{products}</td>
          <td className="align-middle w-25">{link.preview_route}</td>
          <td className="align-middle text-center">
            <div className="button-group">
              <a href={link.edit_route} className="btn btn-sm btn-dark btn-rounded">
                <FontAwesomeIcon icon={faEdit} /> Editar
              </a>
              <button
                onClick={() => this.deletePremiumLink(link['uuid'])}
                className="btn btn-sm btn-dark btn-rounded">
                <FontAwesomeIcon icon={faTrash} /> Eliminar
              </button>
              <a href={link.preview_route} target="_blank" className="btn btn-sm btn-dark btn-rounded">
                <FontAwesomeIcon icon={faEdit} /> Ir a Enlace
              </a>
              
            </div>
          </td>
        </tr>
      );
    });

    return (
      <div className="card">
        <div className="card-body">
          <h4 className="card-title">Listado de Enlaces Premium</h4>
          <div className="table-responsive">
            <table className="table color-table dark-table table-hover table-bordered">
              <thead>
                <tr>
                  <th className="text-center">Nombre</th>
                  <th className="text-center">Fecha Termino</th>
                  <th className="w-25">Productos</th>
                  <th className="w-25">Enlace Premium</th>
                  <th className="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>{links}</tbody>
            </table>
          </div>
        </div>
      </div>
    );
  }
}
