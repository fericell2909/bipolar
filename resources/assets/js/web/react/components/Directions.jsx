import React from 'react';
import ReactDOM from 'react-dom';

export default class BipolarDirections extends React.Component {
  constructor() {
    super();
  }
  
  render() {
    return (
      <div className="row">
        <div className="form-group col-md-6">
          <label htmlFor="name">Nombre</label>
          <input type="text" name="name" className="form-control"/>
        </div>
        <div className="form-group col-md-6">
          <label htmlFor="lastname">Apellidos</label>
          <input type="text" name="lastname" className="form-control"/>
        </div>
      </div>
    )
  }
}

if (document.getElementById('bipolar-directions')) {
  ReactDOM.render(
    <BipolarDirections/>,
    document.getElementById('bipolar-directions')
  );
}