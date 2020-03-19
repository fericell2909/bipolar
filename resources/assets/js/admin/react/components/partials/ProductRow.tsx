import React from 'react';
import { existInArray } from '../../helpers';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faParachuteBox, faStar, faEyeSlash } from '@fortawesome/free-solid-svg-icons';
import { IState } from '../../../../interfaces/IState';
import { ISubtype } from '../../../../interfaces/ISubtype';
import { LazyLoadImage } from 'react-lazy-load-image-component';
import 'react-lazy-load-image-component/src/effects/blur.css';

interface Props {
  key: string;
  selectedProducts: string[];
  hashId: string;
  imageUrl: string;
  name: string;
  subtypes: ISubtype[];
  price: number;
  priceDolar: number;
  discountPEN: number;
  discountUSD: number;
  priceDiscountPEN: number;
  priceDiscountUSD: number;
  state: IState;
  freeShipping: boolean;
  isShowroomSale: boolean;
  isSalient: boolean;
  previewUrl: string;
  clickDelete: (hashId: string) => void;
  clickProductSelect: (event: any) => void;
}

const ProductRow = (props: Props) => {
  const isSelected = existInArray(props.selectedProducts, props.hashId);
  const badgesSubtypes = props.subtypes.map((subtype, id) => {
    return (
      <span key={id.toString()} className="label label-rounded label-inverse">
        {subtype.name_es} / {subtype.name_en}
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
      <FontAwesomeIcon icon={faParachuteBox} />
    </span>
  ) : null;
  const iconSalient = props.isSalient ? (
    <span className="badge badge-dark" data-toggle="tooltip" data-placement="top" title="Destacado">
      <FontAwesomeIcon icon={faStar} />
    </span>
  ) : null;
  const labelShowroomSale = props.isShowroomSale ? (
    <span
      className="badge badge-dark"
      data-toggle="tooltip"
      data-placement="top"
      title="Showroom sale (oculto)">
      <FontAwesomeIcon icon={faEyeSlash} />
    </span>
  ) : null;

  return (
    <tr key={props.hashId}>
      <td className="align-middle">
        <input
          type="checkbox"
          checked={isSelected}
          value={props.hashId}
          onChange={props.clickProductSelect}
        />
      </td>
      <td className="align-middle text-center">
        {props.imageUrl ? (
          <LazyLoadImage alt="Bipolar" effect="blur" width={100} src={props.imageUrl} />
        ) : (
          '--'
        )}
      </td>
      <td className="align-middle">
        {labelShowroomSale} {iconFreeShipping} {iconSalient} {props.name}
      </td>
      <td className="align-middle">{badgesSubtypes}</td>
      <td className="align-middle text-right">{props.price}</td>
      <td className="align-middle text-right">{props.priceDolar}</td>
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
