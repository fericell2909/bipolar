import React from "react";
import { existInArray } from "../../helpers";

const ProductRow = props => {
  const isSelected = existInArray(props.selectedProducts, props.hashId);
  const badgesSubtypes = props.subtypes.map(subtype => {
    return (
      <span key={subtype["hash_id"]} className="badge badge-dark">
        {subtype["name"]}
      </span>
    );
  });
  const state = props.state ? (
    <span className={`badge badge-${props.state.color}`}>
      {props.state.name}
    </span>
  ) : (
    "--"
  );

  return (
    <tr>
      <td>
        <input
          type="checkbox"
          checked={isSelected}
          value={props.hashId}
          onChange={props.clickProductSelect}
        />
      </td>
      <td>
        {props.imageUrl ? <img src={props.imageUrl} width="100" /> : "--"}
      </td>
      <td>{props.name}</td>
      <td>{badgesSubtypes}</td>
      <td className="text-right">{parseInt(props.price)}</td>
      <td className="text-right">{parseInt(props.priceDolar)}</td>
      <td className="text-center">{state}</td>
      <td className="text-center">
        {props.freeShipping ? <i className="fa fa-check" /> : null}
      </td>
      <td className="text-center">
        {props.isSalient !== null ? <i className="fa fa-check" /> : null}
      </td>
      <td>
        <a
          href={props.previewUrl}
          target="_blank"
          className="btn btn-sm btn-dark btn-rounded"
        >
          <i className="fa fa-eye" /> Vista previa
        </a>
        <a
          href={`/admin/products/${props.hashId}/edit`}
          className="btn btn-sm btn-dark btn-rounded"
        >
          <i className="fa fa-pencil" /> Editar
        </a>
        <button
          onClick={() => props.clickDelete(props.hashId)}
          className="btn btn-sm btn-dark btn-rounded"
        >
          <i className="fa fa-trash" /> Descartar
        </button>
      </td>
    </tr>
  );
};

export default ProductRow;
