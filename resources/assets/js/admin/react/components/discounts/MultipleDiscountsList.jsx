import React from 'react';
import * as swal from "sweetalert2";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import axios from 'axios';

export default class MultipleDiscountsList extends React.Component {

  toggleAvailability = (taskId, available) => {
    return swal({
      title: '¿Cambiar disponibilidad de la tarea?',
      text: "Cambiarla a activa hará que esté disponible para ejecutarse automáticamente",
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

  executeTask = taskId => {
    return swal({
      title: '¿Ejecutar tarea?',
      text: "Esta tarea se ejecutará ahora, se aplicarán descuentos a los productos",
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

  revertTask = taskId => {
    return swal({
      title: '¿Revertir tarea?',
      text: "La reversión se ejecutará ahora, se removerán descuentos a los productos",
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

  deleteDiscount = taskId => {
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
      const subtypes = task['product_subtypes_full'] ? task['product_subtypes_full'].map(type => type['name']).join(',') : '';
      const types = task['product_types_full'] ? task['product_types_full'].map(type => type['name']).join(',') : '';
      const products = task['products_full'] ? task['products_full'].map(product => product['fullname']).join(',') : '';
      let executable;
      let available;
      let buttonExecute;
      let buttonActivate;
      
      if (task['available']) {
        available = <FontAwesomeIcon icon="check"/>;
        buttonActivate = (
          <button onClick={() => this.toggleAvailability(task['id'], false)} className="btn btn-sm btn-dark btn-rounded">
            <FontAwesomeIcon icon="times"/> Desactivar
          </button>
        );
      } else {
        available = <FontAwesomeIcon icon="times"/>;
        buttonActivate = (
          <button onClick={() => this.toggleAvailability(task['id'], true)} className="btn btn-sm btn-dark btn-rounded">
            <FontAwesomeIcon icon="check"/> Activar
          </button>
        );
      }

      if (task['available'] && !task['executed']) {
        buttonExecute = (
          <button onClick={() => this.executeTask(task['id'])} className="btn btn-sm btn-dark btn-rounded">
            <FontAwesomeIcon icon="play"/> Ejecutar
          </button>
        );
      }

      if (task['executed']) {
        executable = <FontAwesomeIcon icon="check"/>;
        buttonExecute = (
          <button onClick={() => this.revertTask(task['id'])} className="btn btn-sm btn-dark btn-rounded">
            <FontAwesomeIcon icon="undo-alt"/> Revertir
          </button>
        );
      } else {
        executable = <FontAwesomeIcon icon="times"/>;
      }
      
      return (
        <tr key={task['id']}>
          <td className="align-middle text-center">{task['name']}</td>
          <td className="align-middle text-center">{task['discount_pen']}</td>
          <td className="align-middle text-center">{task['discount_usd']}</td>
          <td className="align-middle text-center">{task['begin']}</td>
          <td className="align-middle text-center">{task['end']}</td>
          <td className="align-middle text-center">{types}</td>
          <td className="align-middle text-center">{subtypes}</td>
          <td className="align-middle text-center">{products}</td>
          <td className="align-middle text-center">{available}</td>
          <td className="align-middle text-center">{executable}</td>
          <td className="align-middle text-center">
            <div className="button-group">
              {buttonActivate}
              {buttonExecute}
              <a href={task['edit_route']} className="btn btn-sm btn-dark btn-rounded">
                <FontAwesomeIcon icon="edit"/> Editar
              </a>
              <button onClick={() => this.deleteDiscount(task['id'])} className="btn btn-sm btn-dark btn-rounded">
                <FontAwesomeIcon icon="trash"/> Eliminar
              </button>
            </div>
          </td>
        </tr>
      );
    });

    return (
      <div className="card">
          <div className="card-body">
            <h4 className="card-title">Tareas de descuento pendientes</h4>
            <div className="table-responsive">
              <table className="table table-hover color-table dark-table">
                <thead>
                  <tr>
                    <th className="text-center">Nombre</th>
                    <th className="text-center">Desc. S/</th>
                    <th className="text-center">Desc. $</th>
                    <th className="text-center">Inicio</th>
                    <th className="text-center">Fin</th>
                    <th className="text-center">Tipos</th>
                    <th className="text-center">Subtipos</th>
                    <th className="text-center">Productos</th>
                    <th className="text-center">Auto-ejecutar</th>
                    <th className="text-center">Ejecutada</th>
                    <th className="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  {tasks}
                </tbody>
              </table>
            </div>
          </div>
        </div>
    );
  }
}