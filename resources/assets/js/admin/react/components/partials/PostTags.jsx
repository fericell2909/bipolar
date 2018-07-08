import React from "react";
import { existInArray } from "../../helpers";

export default class PostTags extends React.Component {
  state = {
    textTag: "",
    tags: []
  };

  handleTypeNewTag = event => this.setState({ textTag: event.target.value });

  handleCreateTag = async event => {
    event.preventDefault();
    if (this.state.textTag.length === 0) {
      return false;
    }
    await axios
      .post("/ajax-admin/tags", { name: this.state.textTag })
      .catch(console.error);
    const responseTags = await this.getTags();
    this.setState({
      textTag: "",
      tags: responseTags.data["data"]
    });
  };

  getTags = async () =>
    await axios.get("/ajax-admin/tags").catch(console.error);

  componentDidMount() {
    this.getTags().then(response =>
      this.setState({ tags: response.data["data"] })
    );
  }

  render() {
    const tags = this.state.tags.map(tag => (
      <div className="checkbox" key={tag["id"]}>
        <input type="checkbox" value={tag["id"]} /> {tag["name"]}
      </div>
    ));

    return (
      <div className="card">
        <div className="card-header bg-dark">
          <h4 className="text-white">Etiquetas</h4>
        </div>
        <div className="card-body">
          <form onSubmit={this.handleCreateTag} className="form-inline mb-3">
            <div className="flex-grow-1 mr-2 form-group">
              <input
                onChange={this.handleTypeNewTag}
                value={this.state.textTag}
                type="text"
                className="w-100 form-control"
                placeholder="Nueva etiqueta"
                required
              />
            </div>
            <button type="submit" className="btn btn-sm btn-dark btn-rounded">
              Crear
            </button>
          </form>
          {tags}
        </div>
      </div>
    );
  }
}
