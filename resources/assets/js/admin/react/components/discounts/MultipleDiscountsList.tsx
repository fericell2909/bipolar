import React from 'react';
import swal from 'sweetalert2';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import axios from 'axios';
import {
  faCalendar,
  faCheck,
  faClock,
  faEdit,
  faPercent,
  faPlay,
  faTimes,
  faTrash,
  faUndoAlt,
} from '@fortawesome/free-solid-svg-icons';
import { IDiscountTask } from '@interfaces/IDiscountTask';

interface Props {
  tasks: IDiscountTask[];
  onUpdateTasks: () => void;
}

export default class MultipleDiscountsList extends React.Component<Props, any> {
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
        this.props.onUpdateTasks();
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
        this.props.onUpdateTasks();
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
        this.props.onUpdateTasks();
      }
    });
  };

  deleteDiscount = (taskId: string) => {
    return swal({
      title: '¿Eliminar tarea de descuento?',
      showCancelButton: true,
      confirmButtonColor: '#000',
      cancelButtonColor: '#000',
      confirmButtonText: 'Sí, eliminar',
    }).then(async result => {
      if (result.value) {
        await axios.delete(`/ajax-admin/discount-tasks/${taskId}`).catch(console.warn);
        swal({
          title: 'Tarea eliminada',
          type: 'success',
          toast: true,
          position: 'top-right',
          showConfirmButton: false,
          timer: 3000,
        });
        this.props.onUpdateTasks();
      }
    });
  };

  render() {
    const tasks = this.props.tasks.map(task => {
      const subtypes = (
        <ul className="row">
          {task.subtypes_model?.map(type => (
            <li key={type.hash_id} className="col-sm-6">{type.name_es}</li>
          ))}
        </ul>
      );
      const products = (
        <ul className="row">
          {task.products_model?.map(product => (
            <li key={product.hash_id} className="col-sm-6">{product.fullname}</li>
          ))}
        </ul>
      );
      let executable;
      let available;
      let buttonExecute;
      let buttonActivate;

      if (task.available) {
        available = (
          <>
            <FontAwesomeIcon icon={faCheck} />
            <span className="ml-2">Auto activar</span>
          </>
        );
        buttonActivate = (
          <button
            onClick={() => this.toggleAvailability(task.hash_id, false)}
            className="btn btn-sm btn-dark btn-rounded">
            <FontAwesomeIcon icon={faTimes} /> Desactivar
          </button>
        );
      } else {
        available = (
          <>
            <FontAwesomeIcon icon={faCheck} />
            <span className="ml-2">Activacion manual</span>
          </>
        );
        buttonActivate = (
          <button
            onClick={() => this.toggleAvailability(task.hash_id, true)}
            className="btn btn-sm btn-dark btn-rounded">
            <FontAwesomeIcon icon={faCheck} /> Activar
          </button>
        );
      }

      if (task.available && !task.executed) {
        buttonExecute = (
          <button
            onClick={() => this.executeTask(task.hash_id)}
            className="btn btn-sm btn-dark btn-rounded">
            <FontAwesomeIcon icon={faPlay} /> Ejecutar
          </button>
        );
      }

      if (task.executed) {
        executable = (
          <>
            <FontAwesomeIcon icon={faCheck} />
            <span className="ml-2">Activada</span>
          </>
        );
        buttonExecute = (
          <button
            onClick={() => this.revertTask(task.hash_id)}
            className="btn btn-sm btn-dark btn-rounded">
            <FontAwesomeIcon icon={faUndoAlt} /> Revertir
          </button>
        );
      } else {
        executable = (
          <>
            <FontAwesomeIcon icon={faClock} />
            <span className="ml-2">Pendiente</span>
          </>
        );
      }

      return (
        <tr key={task.hash_id}>
          <td className="align-middle">
            <span className="d-block font-16" style={{ fontWeight: 600 }}>
              {task.name}
            </span>
            <div className="d-block text-black-50">
              <FontAwesomeIcon icon={faCalendar} />
              <span className="ml-2">
                De {task.begin} a {task.end}
              </span>
            </div>
            {!task.is_2x1 ? (
              <div className="d-block text-black-50">
                <FontAwesomeIcon icon={faPercent} />
                <span className="ml-2">
                  USD: {task.discount_usd} / PEN: {task.discount_pen}
                </span>
              </div>
            ) : null}
            <div className="d-block text-black-50">{executable}</div>
            <div className="d-block text-black-50">{available}</div>
          </td>
          <td className="align-middle w-25">{subtypes}</td>
          <td className="align-middle w-25">{products}</td>
          <td className="align-middle text-center">
            <div className="button-group">
              {buttonActivate}
              {buttonExecute}
              <a href={task.edit_route} className="btn btn-sm btn-dark btn-rounded">
                <FontAwesomeIcon icon={faEdit} /> Editar
              </a>
              <button
                onClick={() => this.deleteDiscount(task['id'])}
                className="btn btn-sm btn-dark btn-rounded">
                <FontAwesomeIcon icon={faTrash} /> Eliminar
              </button>
            </div>
          </td>
        </tr>
      );
    });

    return (
      <div className="card">
        <div className="card-body">
          <h4 className="card-title">Tareas pendientes</h4>
          <div className="table-responsive">
            <table className="table color-table dark-table table-hover table-bordered">
              <thead>
                <tr>
                  <th className="text-center">Nombre</th>
                  <th className="w-25">Subtipos</th>
                  <th className="w-25">Productos</th>
                  <th className="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>{tasks}</tbody>
            </table>
          </div>
        </div>
      </div>
    );
  }
}
