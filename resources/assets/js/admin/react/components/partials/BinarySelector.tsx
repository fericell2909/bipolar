import React from 'react';

interface Props {
  title: string;
  optionSelected: boolean;
  toggleFunction: (value: boolean) => any | void;
  trueText?: string;
  falseText?: string;
}

const BinarySelector = (props: Props) => (
  <>
    <div className="d-block mt-3 mb-1">{props.title}</div>
    <div className="btn-group w-100">
      <button
        onClick={() => props.toggleFunction(true)}
        className={`btn ${props.optionSelected ? 'btn-dark' : 'btn-outline-dark'}`}>
        {props.trueText ?? 'Sí'}
      </button>
      <button
        onClick={() => props.toggleFunction(false)}
        className={`btn ${!props.optionSelected ? 'btn-dark' : 'btn-outline-dark'}`}>
        {props.falseText ?? 'No'}
      </button>
    </div>
  </>
);

export default BinarySelector;
