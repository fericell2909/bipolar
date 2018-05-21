import React from "react";
import ReactDOM from "react-dom";
import { EditorState, ContentState, convertToRaw } from "draft-js";
import htmlToDraft from "html-to-draftjs";
import draftToHtml from "draftjs-to-html";
import { Editor } from "react-draft-wysiwyg";
import axios from "axios";

class PostNew extends React.Component {
  state = {
    title: "",
    titleEnglish: "",
    content: "",
    contentEnglish: "",
    editorState: EditorState.createEmpty(),
    editorStateEnglish: EditorState.createEmpty()
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

  handleChangeEnglishTitle = event => this.setState({ titleEnglish: event.target.value });

  handleSubmit = async event => {
    event.preventDefault();
    const savePost = await axios.post('/ajax-admin/post/new', {
      title: this.state.title,
      title_english: this.state.titleEnglish,
      content: this.state.content,
      content_english: this.state.contentEnglish,
    }).catch(console.error);
    // redirect to list of post
  };

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

    return (
      <div className="row">
        <div className="col-md-9">
          <div className="card">
            <div className="card-body">
              <form onSubmit={this.handleSubmit}>
                <div className="form-row">
                  <div className="col-md-6">
                    <div className="form-group">
                      <label>Título de la publicación</label>
                      <input
                        value={this.state.title}
                        onChange={this.handleChangeTitle}
                        type="text"
                        className="form-control" required={true}
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
                        className="form-control" required={true}
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
                <button type="submit" className="btn btn-dark btn-rounded">Guardar</button>
              </form>
            </div>
          </div>
        </div>
        <div className="col-md-3">
          <div className="card">
            <div className="card-header bg-dark">
              <h4 className="text-white">Categorías</h4>
            </div>
            <div className="card-body">
              Categorías
            </div>
          </div>
          <div className="card">
            <div className="card-header bg-dark">
              <h4 className="text-white">Tags</h4>
            </div>
            <div className="card-body">
              Tags
            </div>
          </div>
        </div>
      </div>
    );
  }
}

if (document.getElementById("bipolar-create-post")) {
  const elem = document.getElementById("bipolar-create-post");
  ReactDOM.render(<PostNew />, elem);
}
