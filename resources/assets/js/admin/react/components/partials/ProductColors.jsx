import React from 'react';
import {existInArray} from "../../helpers";

export default class ProductColors extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      searchedColors: [],
      textSearchColors: "",
    };

    this.handleSearchColors = this.handleSearchColors.bind(this);
  }

  handleSearchColors(event) {
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
          <label>
            <input type="checkbox" checked={isSelected} value={color['hash_id']} onChange={this.props.toggleCheck}/>
            {color['name']}
          </label>
        </div>
      );
    });

    return (
      <div className="white-box">
        <div className="panel panel-inverse">
          <div className="panel-heading">Colores</div>
        </div>
        <div className="panel-wrapper collapse in">
          <div className="panel-body">
            <input value={this.state.textSearchColors} onChange={this.handleSearchColors} type="text"
                   className="form-control" placeholder="Buscar color"/>
            {colorsRender.length ? colorsRender : 'No hay colores'}
          </div>
        </div>
      </div>
    );
  }
}