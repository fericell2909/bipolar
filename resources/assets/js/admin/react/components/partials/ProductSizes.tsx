import React from 'react';
import { existInArray } from '../../helpers';

const ProductSizes = props => {
  const sizesRender = props.sizes.map(size => {
    const isSelected = existInArray(props.selected, size['hash_id']);
    return (
      <div key={size['hash_id']} className="checkbox">
        <input
          type="checkbox"
          checked={isSelected}
          value={size['hash_id']}
          onChange={props.toggleCheck}
        />
        <label>{size['name']}</label>
      </div>
    );
  });

  return (
    <div className="card">
      <div className="card-header bg-dark">
        <h4 className="text-white">Tallas</h4>
      </div>
      <div className="card-body">{sizesRender.length ? sizesRender : 'No hay tallas'}</div>
    </div>
  );
};

export default ProductSizes;
