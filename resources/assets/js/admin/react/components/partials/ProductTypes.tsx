import React from 'react';
import { existInArray } from '../../helpers';

const ProductTypes = props => {
  const typesRender = props.types.map(type => {
    let subtypes = [];
    if (type['subtypes']) {
      subtypes = type['subtypes'].map(subtype => {
        const isSelected = existInArray(props.selected, subtype['hash_id']);
        return (
          <div key={subtype['hash_id']} className="checkbox">
            <input
              type="checkbox"
              checked={isSelected}
              value={subtype['hash_id']}
              onChange={props.toggleCheck}
            />
            <label>{subtype['name']}</label>
          </div>
        );
      });
    }

    return (
      <div className="card" key={type['hash_id']}>
        <div className="card-header bg-dark">
          <h4 className="text-white">Tipo de {type['name']}</h4>
        </div>
        <div className="card-body">{subtypes.length ? subtypes : 'No hay subtipos'}</div>
      </div>
    );
  });

  return typesRender.length ? typesRender : 'No hay tipos';
};

export default ProductTypes;
