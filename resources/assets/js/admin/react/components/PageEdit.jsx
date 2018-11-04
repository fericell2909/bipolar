import React from "react";
import ReactDOM from "react-dom";
import {EditorState, convertToRaw, ContentState} from "draft-js";
import draftToHtml from "draftjs-to-html";
import { Editor } from "react-draft-wysiwyg";
import axios from "axios";
import htmlToDraft from "html-to-draftjs";

class PageEdit extends React.Component {
  state = {
    title: "",
    titleEnglish: "",
    content: "",
    contentEnglish: "",
    stateSelected: "",
    editorState: EditorState.createEmpty(),
    editorStateEnglish: EditorState.createEmpty(),
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
    const updatePage = await axios
      .put(`/ajax-admin/pages/${this.props.pageId}`, {
        title: this.state.title,
        title_english: this.state.titleEnglish,
        content: this.state.content,
        content_english: this.state.contentEnglish,
      })
      .catch(console.error);
    if (updatePage.data["redirect_url"]) {
      window.location.href = updatePage.data["redirect_url"];
    }
  };

  componentDidMount() {
    axios.get(`/ajax-admin/pages/${this.props.pageId}`).then(response => {
      const page = response.data["data"];
      let { editorState, editorStateEnglish } = this.state;
      let contentBlock, contentBlockEnglish = null;
      let content, contentEnglish = null;

      if (page["body_es"] !== null) {
        content = page['body_es'];
        contentBlock = htmlToDraft(page["body_es"]);
        const contentState = ContentState.createFromBlockArray(
          contentBlock.contentBlocks
        );
        editorState = EditorState.createWithContent(contentState);
      }
      if (page["body_en"] !== null) {
        contentEnglish = page['body_en'];
        contentBlockEnglish = htmlToDraft(page["body_en"]);
        const contentStateEnglish = ContentState.createFromBlockArray(
          contentBlockEnglish.contentBlocks
        );
        editorStateEnglish = EditorState.createWithContent(contentStateEnglish);
      }


      this.setState({
        title: page["title_es"],
        titleEnglish: page["title_en"],
        editorState,
        editorStateEnglish,
        content,
        contentEnglish,
      });
    });
  }

  render() {
    const toolbarEditor = {
      fontFamily: {
        options: ['Verdana', 'GothamLight'],
      },
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
        <div className="col-12">
          <div className="card">
            <div className="card-body">
              <form onSubmit={this.handleSubmit}>
                <div className="form-row">
                  <div className="col-md-6">
                    <div className="form-group">
                      <label>Título de la página</label>
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
                  <label>Contenido</label>
                  <Editor
                    editorState={this.state.editorState}
                    toolbar={toolbarEditor}
                    onEditorStateChange={this.handleEditorDescription}
                    editorClassName="demo-editor-content"
                  />
                </div>
                <div className="form-group">
                  <label>Contenido en inglés</label>
                  <Editor
                    editorState={this.state.editorStateEnglish}
                    toolbar={toolbarEditor}
                    onEditorStateChange={this.handleEditorDescriptionEnglish}
                    editorClassName="demo-editor-content"
                  />
                </div>
                <button type="submit" className="btn btn-dark btn-rounded">Actualizar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

if (document.getElementById("bipolar-edit-page")) {
  const pageId = window.BipolarPageId;
  const elem = document.getElementById("bipolar-edit-page");
  ReactDOM.render(<PageEdit pageId={pageId}/>, elem);
}
