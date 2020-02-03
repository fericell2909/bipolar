import React from 'react';
import { existInArray } from '../../helpers';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

const ProductRow = props => {
  const isSelected = existInArray(props.selectedProducts, props.hashId);
  const badgesSubtypes = props.subtypes.map(subtype => {
    return (
      <span key={subtype['hash_id']} className="label label-rounded label-inverse">
        {subtype['name']}
      </span>
    );
  });
  const state = props.state ? (
    <span className={`label label-rounded label-${props.state.color}`}>{props.state.name}</span>
  ) : (
    '--'
  );
  let priceDiscountText;
  let discountText;
  if (props.priceDiscountPEN && props.priceDiscountUSD) {
    priceDiscountText = `${props.priceDiscountPEN}/${props.priceDiscountUSD}`;
  }
  if (props.discountPEN && props.discountUSD) {
    discountText = `${props.discountPEN}%/${props.discountUSD}%`;
  }

  const iconFreeShipping = props.freeShipping ? (
    <span
      className="badge badge-dark"
      data-toggle="tooltip"
      data-placement="top"
      title="Free shipping">
      <FontAwesomeIcon icon="parachute-box" />
    </span>
  ) : null;
  const iconSalient =
    props.isSalient !== null ? (
      <span
        className="badge badge-dark"
        data-toggle="tooltip"
        data-placement="top"
        title="Destacado">
        <FontAwesomeIcon icon="star" />
      </span>
    ) : null;
  const labelShowroomSale = props.isShowroomSale ? (
    <span
      className="badge badge-dark"
      data-toggle="tooltip"
      data-placement="top"
      title="Showroom sale (oculto)">
      <FontAwesomeIcon icon="eye-slash" />
    </span>
  ) : null;

  return (
    <tr>
      <td className="align-middle">
        <input
          type="checkbox"
          checked={isSelected}
          value={props.hashId}
          onChange={props.clickProductSelect}
        />
      </td>
      <td className="align-middle text-center">
        {props.imageUrl ? <img src={props.imageUrl} width="100" /> : '--'}
      </td>
      <td className="align-middle">
        {labelShowroomSale} {iconFreeShipping} {iconSalient} {props.name}
      </td>
      <td className="align-middle">{badgesSubtypes}</td>
      <td className="align-middle text-right">{parseInt(props.price)}</td>
      <td className="align-middle text-right">{parseInt(props.priceDolar)}</td>
      <td className="align-middle text-center">{discountText}</td>
      <td className="align-middle text-right">{priceDiscountText}</td>
      <td className="align-middle text-center">{state}</td>
      <td className="align-middle">
        <div className="button-group">
          <a href={props.previewUrl} target="_blank" className="btn btn-sm btn-dark btn-rounded">
            <i className="fas fa-fw fa-eye" /> Vista previa
          </a>
          <a
            href={`/admin/products/${props.hashId}/edit`}
            className="btn btn-sm btn-dark btn-rounded">
            <i className="fas fa-fw fa-edit" /> Editar
          </a>
          <button
            onClick={() => props.clickDelete(props.hashId)}
            className="btn btn-sm btn-dark btn-rounded">
            <i className="fas fa-fw fa-trash" /> Descartar
          </button>
        </div>
      </td>
    </tr>
  );
};

export default ProductRow;
