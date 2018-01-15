import React from "react";
import {existInArray} from "../../helpers";

const ProductTypes = props => {
  const typesRender = props.types.map(type => {
    let subtypes = [];
    if (type['subtypes']) {
      subtypes = type['subtypes'].map(subtype => {
        const isSelected = existInArray(props.selected, subtype['hash_id']);
        return (
          <div key={subtype['hash_id']} className="checkbox">
            <label>
              <input type="checkbox"
                     checked={isSelected}
                     value={subtype['hash_id']}
                     onChange={props.toggleCheck}/>
              {subtype['name']}
            </label>
          </div>
        );
      });
    }

    return (
      <div className="white-box" key={type['hash_id']}>
        <div className="panel panel-inverse">
          <div className="panel-heading">Tipo de {type['name']}</div>
        </div>
        <div className="panel-wrapper collapse in">
          <div className="panel-body">
            {subtypes.length ? subtypes : 'No hay subtipos'}
          </div>
        </div>
      </div>
    );
  });

  return typesRender.length ? typesRender : 'No hay tipos';
};

export default ProductTypes;