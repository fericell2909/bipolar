import React from 'react';
import swal from 'sweetalert2';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {
  faCheck,
  faEdit,
  faEye,
  faTrash,
  faWindowClose,
} from '@fortawesome/free-solid-svg-icons';
import { ITextCondition } from '@interfaces/ITextCondition';
import GraphqlAdmin from '../../../graphql-admin';
import { gql } from 'apollo-boost';

interface Props {
  textconditions: ITextCondition[];
  onUpdateTextConditions: () => void;
}

export default class TextConditionsList extends React.Component<Props, any> {
  toggleAvailability = (uuId: string, available: boolean) => {

    let text_message = available ? 'Esto Inactivará el  Estado.' : 'Esto Activará el Estado e deshabilitará los demás.';

    return swal({
      title: '¿Desea Cambiar el Estado del Texto?',
      text: text_message,
      showCancelButton: true,
      confirmButtonColor: '#000',
      cancelButtonColor: '#000',
      confirmButtonText: 'Sí, cambiar',
      cancelButtonText: 'Cancelar',
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
          uuid: uuId,
        };

        await GraphqlAdmin.mutation(
          gql`
            mutation TextConditionStatusUpdation(
              $uuid: String!
            ) {
              text_condition_status_updation(
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
              position: 'center',
              showConfirmButton: false,
              timer: 3000,
            });
          }
          )
          .then(() => {
            swal({
              title: 'Se Actualizó el Estado Correctamente.',
              type: 'success',
              toast: true,
              position: 'center',
              showConfirmButton: false,
              timer: 3000,
            });
          });

        this.props.onUpdateTextConditions();

      }
    });
  };


  deleteTextCondition = (uuId: string) => {
    return swal({
      title: '¿Desea Eliminar el Texto que aparece en los productos?',
      showCancelButton: true,
      confirmButtonColor: '#000',
      cancelButtonColor: '#000',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
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
          uuid: uuId,
        };

        await GraphqlAdmin.mutation(
          gql`
            mutation TextConditionDeletion(
              $uuid: String!
            ) {
              text_condition_deletion(
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
              title: 'Se Eliminó el Texto Correctamente.',
              type: 'success',
              toast: true,
              position: 'top-right',
              showConfirmButton: false,
              timer: 3000,
            });
          });

        this.props.onUpdateTextConditions();

      }
    });
  };

  render() {

    const textconditions = this.props.textconditions.map(textcondition => {

      let lblState;
      let ButtonState;

      if (textcondition.available) {

        lblState = (
          <>
            <span className="label label-success">Activo</span>
          </>
        );

        ButtonState = (
          <>
            <button
              onClick={() => this.toggleAvailability(textcondition.uuid, textcondition.available)}
              className="btn btn-sm btn-danger btn-rounded">
              <FontAwesomeIcon icon={faWindowClose} /> Inactivar
            </button>
          </>
        );

      } else {
        lblState = (
          <>
            <span className="label label-danger">Inactivo</span>
          </>
        );
        ButtonState = (
          <>
            <button
              onClick={() => this.toggleAvailability(textcondition.uuid, textcondition.available)}
              className="btn btn-sm btn-success btn-rounded">
              <FontAwesomeIcon icon={faCheck} /> Activar
            </button>
          </>
        );
      }

      return (
        <tr key={textcondition.hash_id}>
          <td className="align-left">
            <span className="d-block font-16" style={{ fontWeight: 600 }}>
              {textcondition.name}
            </span>
          </td>
          <td className="align-center text-center">
            {lblState}
          </td>
          <td className="align-middle text-center">
            <div className="button-group">
              {ButtonState}
              <a href={textcondition.edit_route} className="btn btn-sm btn-dark btn-rounded">
                <FontAwesomeIcon icon={faEdit} /> Editar
              </a>
              <button
                onClick={() => this.deleteTextCondition(textcondition['uuid'])}
                className="btn btn-sm btn-dark btn-rounded">
                <FontAwesomeIcon icon={faTrash} /> Eliminar
              </button>
              <a href={textcondition.preview_route} target="_blank" className="btn btn-sm btn-dark btn-rounded">
                <FontAwesomeIcon icon={faEye} /> Vista Previa
              </a>
            </div>
          </td>
        </tr>
      );
    });

    return (
      <div className="card">
        <div className="card-body">
          <h4 className="card-title">Listado de Textos</h4>
          <div className="table-responsive">
            <table className="table color-table dark-table table-hover table-bordered">
              <thead>
                <tr>
                  <th className="w-65 text-left">Nombre Referencial</th>
                  <th className="w-15  text-center">Estado</th>
                  <th className="w-20 text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>{textconditions}</tbody>
            </table>
          </div>
        </div>
      </div>
    );
  }
}
