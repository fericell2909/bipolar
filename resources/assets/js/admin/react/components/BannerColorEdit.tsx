import React, { Component } from 'react';
import { ContentState, convertToRaw, EditorState } from 'draft-js';
import htmlToDraft from 'html-to-draftjs';
import draftToHtml from 'draftjs-to-html';
import { Editor } from 'react-draft-wysiwyg';
import ReactDOM from 'react-dom';
import GraphqlAdmin from '../../graphql-admin';
import { IBanner } from '@interfaces/IBanner';
import Iframe from 'react-iframe';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCircleNotch } from '@fortawesome/free-solid-svg-icons';

interface State {
  isLoading: boolean;
  banner: IBanner;
  editorStateSpanish: EditorState;
  editorStateEnglish: EditorState;
}

interface Props {
  bannerColorId: number;
  bannerHashId: string;
}

class BannerColorEdit extends Component<Props, State> {
  state = {
    isLoading: true,
    editorStateSpanish: EditorState.createEmpty(),
    editorStateEnglish: EditorState.createEmpty(),
    banner: null,
  };

  handleEditorDescription = editorState => {
    const htmlText = draftToHtml(convertToRaw(editorState.getCurrentContent()));
    this.setState({
      editorStateSpanish: editorState,
      banner: { ...this.state.banner, text_es: htmlText },
    });
  };

  handleEditorDescriptionEnglish = editorState => {
    const htmlText = draftToHtml(convertToRaw(editorState.getCurrentContent()));
    this.setState({
      editorStateEnglish: editorState,
      banner: { ...this.state.banner, text_en: htmlText },
    });
  };

  updateBannerText = async () => {
    await this.setState({ isLoading: true });
    const { hash_id, text_es, text_en } = this.state.banner;
    const { data } = await GraphqlAdmin.updateBanner({ hash_id, text_en, text_es });
    this.setState({ banner: data.banner, isLoading: false });
  };

  async componentDidMount() {
    const { data } = await GraphqlAdmin.getBanner(this.props.bannerHashId);
    const banner = data.banner;
    let { editorStateSpanish, editorStateEnglish } = this.state;
    let contentBlock,
      contentBlockEnglish = null;
    if (banner.text_es !== null) {
      contentBlock = htmlToDraft(banner.text_es);
      const contentState = ContentState.createFromBlockArray(contentBlock.contentBlocks);
      editorStateSpanish = EditorState.createWithContent(contentState);
    }
    if (banner.text_en !== null) {
      contentBlockEnglish = htmlToDraft(banner.text_en);
      const contentStateEnglish = ContentState.createFromBlockArray(
        contentBlockEnglish.contentBlocks
      );
      editorStateEnglish = EditorState.createWithContent(contentStateEnglish);
    }
    this.setState({ banner, editorStateSpanish, editorStateEnglish, isLoading: false });
  }

  render() {
    const toolbarEditor = {
      fontFamily: {
        options: ['GothamLight', 'GothamBold', 'SaharaBodoni'],
      },
      fontSize: {
        options: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 24, 30, 36, 48],
      },
    };

    const iFramePreview = (
      <Iframe
        url={`/admin/banners/${this.props.bannerColorId}/preview`}
        width="100%"
        height="100%"
        loading="lazy"
      />
    );

    const iPadPreview = (
      <div className="marvel-device ipad black">
        <div className="camera" />
        <div className="screen">{iFramePreview}</div>
        <div className="home" />
      </div>
    );

    const iPhonePreview = (
      <div className="marvel-device iphone8 black">
        <div className="top-bar" />
        <div className="sleep" />
        <div className="volume" />
        <div className="camera" />
        <div className="sensor" />
        <div className="speaker" />
        <div className="screen">{iFramePreview} </div>
        <div className="home" />
        <div className="bottom-bar" />
      </div>
    );

    const macPreview = (
      <div className="marvel-device macbook">
        <div className="top-bar" />
        <div className="camera" />
        <div className="screen">{iFramePreview}</div>
        <div className="bottom-bar" />
      </div>
    );

    return (
      <>
        <div className="card">
          <div className="card-body">
            <div className="form-group">
              <label>Descripción (Opcional)</label>
              <Editor
                toolbar={toolbarEditor}
                stripPastedStyles={true}
                editorState={this.state.editorStateSpanish}
                onEditorStateChange={this.handleEditorDescription}
                editorClassName="demo-editor-content"
              />
            </div>
            <div className="form-group">
              <label>Descripción en inglés (Opcional)</label>
              <Editor
                toolbar={toolbarEditor}
                stripPastedStyles={true}
                editorState={this.state.editorStateEnglish}
                onEditorStateChange={this.handleEditorDescriptionEnglish}
                editorClassName="demo-editor-content"
              />
            </div>
          </div>
          <div className="card-footer">
            <button className="btn btn-dark" onClick={this.updateBannerText}>
              {this.state.isLoading ? (
                <>
                  <FontAwesomeIcon icon={faCircleNotch} spin />
                  <span>Procesando</span>
                </>
              ) : (
                <span>Actualizar</span>
              )}
            </button>
          </div>
        </div>
        <div className="row mt-5 p-5">
          <div className="col">{iPhonePreview}</div>
          <div className="col">{iPadPreview}</div>
        </div>
        <div className="row mt-5 p-5">
          <div className="col">{macPreview}</div>
        </div>
      </>
    );
  }
}

if (document.getElementById('bipolar-banner-color-edit')) {
  const BannerColorHashId = (window as any).BannerColorHashId!;
  const BannerColorId = (window as any).BannerColorId!;
  ReactDOM.render(
    <BannerColorEdit bannerHashId={BannerColorHashId} bannerColorId={BannerColorId} />,
    document.getElementById('bipolar-banner-color-edit')
  );
}
