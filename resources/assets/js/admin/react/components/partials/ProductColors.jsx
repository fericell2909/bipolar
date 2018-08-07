import React from 'react';
import {existInArray} from "../../helpers";

export default class ProductColors extends React.Component {

  state = {
    searchedColors: [],
    textSearchColors: "",
  };
  stylesColors = { height: 300, overflowY: 'scroll' };

  handleSearchColors = event => {
    const search = event.target.value.toLowerCase();

    if (search.length === 0) {
      return this.setState({
        searchedColors: [],
        textSearchColors: '',
      });
    }

    const filtered = this.props.colors.filter(color => color.name.toLowerCase().search(search) !== -1);

    return this.setState({
      searchedColors: filtered,
      textSearchColors: search,
    })
  }

  render() {
    const colors = (this.state.searchedColors.length === 0 && this.state.textSearchColors.length === 0)
      ? [...this.props.colors]
      : [...this.state.searchedColors];

    const colorsRender = colors.map(color => {
      const isSelected = existInArray(this.props.selected, color['hash_id']);
      return (
        <div key={color['hash_id']} className="checkbox">
          <input type="checkbox" checked={isSelected} value={color['hash_id']} onChange={this.props.toggleCheck}/>
          <label> {color['name']}</label>
        </div>
      );
    });

    return (
      <div className="card">
        <div className="card-header bg-dark">
          <h4 className="text-white">Colores</h4>
        </div>
        <div className="card-body" style={this.stylesColors}>
          <input value={this.state.textSearchColors} onChange={this.handleSearchColors} type="text"
            className="form-control mb-3" placeholder="Buscar color" />
          {colorsRender.length ? colorsRender : 'No hay colores'}
        </div>
      </div>
    );
  }
}