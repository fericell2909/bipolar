import React from 'react';
import {existInArray} from "../../helpers";

const ProductSizes = props => {
  const sizesRender = props.sizes.map(size => {
    const isSelected = existInArray(props.selected, size['hash_id']);
    return (
      <div key={size['hash_id']} className="checkbox">
        <label>
          <input type="checkbox"
                 checked={isSelected}
                 value={size['hash_id']}
                 onChange={props.toggleCheck}/>
          {size['name']}
        </label>
      </div>
    );
  });

  return (
    <div className="white-box">
      <div className="panel panel-inverse">
        <div className="panel-heading">Tallas</div>
      </div>
      <div className="panel-wrapper collapse in">
        <div className="panel-body">
          {sizesRender.length ? sizesRender : 'No hay tallas'}
        </div>
      </div>
    </div>
  );
};

export default ProductSizes;