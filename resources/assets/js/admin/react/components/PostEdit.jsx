import React from "react";
import ReactDOM from "react-dom";
import { EditorState, ContentState, convertToRaw } from "draft-js";
import htmlToDraft from "html-to-draftjs";
import draftToHtml from "draftjs-to-html";
import { Editor } from "react-draft-wysiwyg";
import axios from "axios";
import PostCategories from "./partials/PostCategories";
import PostTags from "./partials/PostTags";
import { removeFromSimpleArray } from "../helpers";

class PostEdit extends React.Component {
  state = {
    title: "",
    titleEnglish: "",
    content: "",
    contentEnglish: "",
    stateSelected: "",
    editorState: EditorState.createEmpty(),
    editorStateEnglish: EditorState.createEmpty(),
    states: [],
    selectedCategories: [],
    selectedTags: []
  };

  checkCategory = event => {
    const categoryHashId = event.target.value;
    let selectedCategories = this.state.selectedCategories;

    if (event.target.checked) {
      selectedCategories.push(categoryHashId);
    } else {
      selectedCategories = removeFromSimpleArray(
        selectedCategories,
        categoryHashId
      );
    }

    return this.setState({ selectedCategories });
  };

  checkTag = event => {
    const tagHashId = event.target.value;
    let selectedTags = this.state.selectedTags;

    if (event.target.checked) {
      selectedTags.push(tagHashId);
    } else {
      selectedTags = removeFromSimpleArray(selectedTags, tagHashId);
    }

    return this.setState({ selectedTags });
  };

  handleEditorDescription = editorState => {
    const htmlText = draftToHtml(convertToRaw(editorState.getCurrentContent()));
    this.setState({
      editorState,
      content: htmlText
    });
  };

  handleEditorDescriptionEnglish = editorStateEnglish => {
    const htmlText = draftToHtml(
      convertToRaw(editorStateEnglish.getCurrentContent())
    );
    this.setState({
      editorStateEnglish,
      contentEnglish: htmlText
    });
  };

  handleChangeTitle = event => this.setState({ title: event.target.value });

  handleChangeEnglishTitle = event =>
    this.setState({ titleEnglish: event.target.value });

  updatePost = async event => {
    event.preventDefault();
    const savePost = await axios
      .put(`/ajax-admin/post/${this.props.postId}/update`, {
        title: this.state.title,
        title_english: this.state.titleEnglish,
        content: this.state.content,
        content_english: this.state.contentEnglish,
        state: this.state.stateSelected,
        categories: this.state.selectedCategories,
        tags: this.state.selectedTags
      })
      .catch(console.error);
    if (savePost.data["redirect_url"]) {
      window.location.href = savePost.data["redirect_url"];
    }
  };

  handleChangeSelect = event =>
    this.setState({ stateSelected: event.target.value });

  componentDidMount() {
    axios
      .get("/ajax-admin/states")
      .then(({ data }) => this.setState({ states: data["data"] }))
      .catch(console.error);

    axios.get(`/ajax-admin/post/${this.props.postId}/show`).then(response => {
      const post = response.data["data"];
      let { editorState, editorStateEnglish } = this.state;
      let contentBlock,
        contentBlockEnglish = null;

      if (post["content_es"] !== null) {
        contentBlock = htmlToDraft(post["content_es"]);
        const contentState = ContentState.createFromBlockArray(
          contentBlock.contentBlocks
        );
        editorState = EditorState.createWithContent(contentState);
      }
      if (post["content_en"] !== null) {
        contentBlockEnglish = htmlToDraft(post["content_en"]);
        const contentStateEnglish = ContentState.createFromBlockArray(
          contentBlockEnglish.contentBlocks
        );
        editorStateEnglish = EditorState.createWithContent(contentStateEnglish);
      }

      const categories = post.categories.map(category => category["hash_id"]);
      const tags = post.tags.map(tag => tag["hash_id"]);

      this.setState({
        title: post["title_es"],
        titleEnglish: post["title_en"],
        stateSelected: post["state"]["hash_id"],
        editorState,
        editorStateEnglish,
        selectedCategories: categories,
        selectedTags: tags
      });
    });
  }

  render() {
    const toolbarEditor = {
      image: {
        urlEnabled: true,
        uploadEnabled: true,
        uploadCallback: async image => {
          const formData = new FormData();
          formData.append("image", image);
          const uploadPhoto = await axios
            .post("/ajax-admin/post/photos", formData)
            .catch(console.error);
          return uploadPhoto.data;
        },
        previewImage: true,
        inputAccept: "image/gif,image/jpeg,image/jpg,image/png,image/svg",
        alt: { present: false, mandatory: false }
      }
    };

    const statesOptions = this.state.states.map(state => (
      <option key={state["hash_id"]} value={state["hash_id"]}>
        {state["name"]}
      </option>
    ));

    return (
      <div className="row">
        <div className="col-md-9">
          <div className="card">
            <div className="card-body">
              <form onSubmit={this.updatePost}>
                <div className="form-row">
                  <div className="col-md-6">
                    <div className="form-group">
                      <label>Título de la publicación</label>
                      <input
                        value={this.state.title}
                        onChange={this.handleChangeTitle}
                        type="text"
                        className="form-control"
                        required={true}
                      />
                    </div>
                  </div>
                  <div className="col-md-6">
                    <div className="form-group">
                      <label>Título de la publicación (Inglés)</label>
                      <input
                        value={this.state.titleEnglish}
                        onChange={this.handleChangeEnglishTitle}
                        type="text"
                        className="form-control"
                        required={true}
                      />
                    </div>
                  </div>
                </div>
                <div className="form-group">
                  <label>Contenido (Opcional)</label>
                  <Editor
                    editorState={this.state.editorState}
                    toolbar={toolbarEditor}
                    onEditorStateChange={this.handleEditorDescription}
                    editorClassName="demo-editor-content"
                  />
                </div>
                <div className="form-group">
                  <label>Contenido en inglés (Opcional)</label>
                  <Editor
                    editorState={this.state.editorStateEnglish}
                    toolbar={toolbarEditor}
                    onEditorStateChange={this.handleEditorDescriptionEnglish}
                    editorClassName="demo-editor-content"
                  />
                </div>
                <div className="form-row">
                  <div className="col-md-6">
                    <div className="form-group">
                      <label>Estado</label>
                      <select
                        onChange={this.handleChangeSelect}
                        value={this.state.stateSelected}
                        className="form-control"
                        required={true}
                      >
                        <option value="" disabled>
                          Seleccione
                        </option>
                        {statesOptions}
                      </select>
                    </div>
                  </div>
                </div>
                <button type="submit" className="btn btn-dark btn-rounded">
                  Guardar
                </button>
              </form>
            </div>
          </div>
        </div>
        <div className="col-md-3">
          <PostCategories
            selected={this.state.selectedCategories}
            checked={this.checkCategory}
          />
          <PostTags
            selected={this.state.selectedTags}
            checked={this.checkTag}
          />
        </div>
      </div>
    );
  }
}

if (document.getElementById("bipolar-edit-post")) {
  const postId = window.BipolarPostId;
  const elem = document.getElementById("bipolar-edit-post");
  ReactDOM.render(<PostEdit postId={postId} />, elem);
}
