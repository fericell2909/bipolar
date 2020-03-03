import React from 'react';
import { existInArray } from '../../helpers';
import axios from 'axios';

export default class PostCategories extends React.Component<any> {
  state = {
    textCategory: '',
    categories: [],
  };

  typeNewCategory = event => this.setState({ textCategory: event.target.value });

  handleCreateCategory = async event => {
    event.preventDefault();
    if (this.state.textCategory.length === 0) {
      return false;
    }
    await axios
      .post('/ajax-admin/categories', { name: this.state.textCategory })
      .catch(console.error);
    const responseCategories = await this.getCategories();
    this.setState({
      textCategory: '',
      //@ts-ignore
      categories: responseCategories.data['data'],
    });
  };

  getCategories = async () => await axios.get('/ajax-admin/categories').catch(console.error);

  componentDidMount() {
    //@ts-ignore
    this.getCategories().then(response => this.setState({ categories: response.data['data'] }));
  }

  render() {
    const categories = this.state.categories.map(category => {
      const isSelected = existInArray(this.props.selected, category['hash_id']);
      return (
        <div className="checkbox" key={category['hash_id']}>
          <input
            type="checkbox"
            value={category['hash_id']}
            checked={isSelected}
            onChange={this.props.checked}
          />{' '}
          {category['name']}
        </div>
      );
    });

    return (
      <div className="card">
        <div className="card-header bg-dark">
          <h4 className="text-white">Categorías</h4>
        </div>
        <div className="card-body">
          <form onSubmit={this.handleCreateCategory} className="form-inline mb-3">
            <div className="flex-grow-1 mr-2 form-group">
              <input
                onChange={this.typeNewCategory}
                value={this.state.textCategory}
                type="text"
                className="w-100 form-control"
                placeholder="Nueva categoría"
                required
              />
            </div>
            <button type="submit" className="btn btn-sm btn-dark btn-rounded">
              Crear
            </button>
          </form>
          {categories}
        </div>
      </div>
    );
  }
}
