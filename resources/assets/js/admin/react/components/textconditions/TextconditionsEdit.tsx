import React, { Fragment } from 'react';
import ReactDOM from 'react-dom';
import { EditorState, ContentState, convertToRaw } from 'draft-js';
import { Editor } from 'react-draft-wysiwyg';
import draftToHtml from 'draftjs-to-html';
import htmlToDraft from 'html-to-draftjs';
import GraphqlAdmin from '../../../graphql-admin';
import { gql } from 'apollo-boost';
import { ITextCondition } from '@interfaces/ITextCondition';
import swal from 'sweetalert2';

interface Props {
  uuId: string;
}

class TextConditionsEdit extends React.Component<Props,any> {
  state = {
    name: '',
    nameEnglish: '',
    // form data
    description: '',
    descriptionEnglish: '',
    editorState: EditorState.createEmpty(),
    editorStateEnglish: EditorState.createEmpty(),
    showErrorMessage: false,
    readOnly: false,
  };


  handleNameChange = event => this.setState({ name: event.target.value });

  handleSaveTextCondition = async event => {

    event.preventDefault();

    if (!(this.Validate(this.state.name))) {
      
      this.messageValidate('Debe Ingresar un Nombre Referencial', 'warning');
      return false;
    }

    if (!(this.Validate(this.state.nameEnglish))) {
      
      this.messageValidate('Debe Ingresar un Nombre Referencial (inglés)', 'warning');
      return false;

    }

    if (!(this.Validate(this.state.description))) {
      
      this.messageValidate('Debe Ingresar una Descripción', 'warning');
      return false;
    }

    if (!(this.Validate(this.state.descriptionEnglish))) {
      
      this.messageValidate('Debe Ingresar una Descripción (inglés)', 'warning');
      return false;
      
    }

    // testinf.
    // console.log(this.state.description_english);

    let variables: {} = {
      uuid: this.props.uuId,
      name: this.state.name,
      name_english: this.state.nameEnglish,
      description: this.state.description,
      description_english: this.state.descriptionEnglish,
    };

    swal({
      title: 'Procesando ...',
      toast: true,
      position: 'top-right',
      showConfirmButton: false,
      onOpen: () => swal.showLoading(),
    });


    await GraphqlAdmin.mutation(
      gql`
        mutation TextConditionUpdation(
          $uuid: String!
          $name: String!
          $name_english: String!
          $description: String!
          $description_english: String!
        ) {
          text_condition_updation(
            uuid: $uuid
            name: $name
            name_english: $name_english
            description: $description
            description_english: $description_english
          ) {
            name
          }
        }
      `,
      variables
    )
      .catch(console.warn)
      .then(() => {
        //this.clean();
      
        swal.close();
       
      }).finally(() => {
        this.messageValidate('Datos Actualizados correctamente.', 'success');
      });

  };

  messageValidate( message, type) {
    
    swal({
      title: message,
      type: type,
      toast: false,
      position: 'center',
      showConfirmButton: true,
    });


  }

  Validate(val) { 
    
    if (val === '' || val.length <= 0 || val.trim() === '') {
    
      return false;
  
    } else {

      return true;
    
    }
  
  }
  
  handleInputChange = event => {
    this.setState({ ...this.state, [event.target.name]: event.target.value });
  };

  handleEditorDescription = (editorState: { getCurrentContent: () => any; }) => {
    const htmlText = draftToHtml(convertToRaw(editorState.getCurrentContent()));
    this.setState({ editorState, description: htmlText });
  };

  handleEditorDescriptionEnglish = (editorState: { getCurrentContent: () => any; }) => {
    const htmlText = draftToHtml(convertToRaw(editorState.getCurrentContent()));
    this.setState({ editorStateEnglish: editorState, descriptionEnglish: htmlText });
  };
  
  
 
  getTextCondition = async () => {
    // @ts-ignore
    
    //const task = data['data'];

    let variables: {} = {
      uuid: this.props.uuId,
    };

    swal({
      title: 'Obteniendo Información...',
      toast: true,
      position: 'top-right',
      showConfirmButton: false,
      onOpen: () => swal.showLoading(),
    });


    const { data } = await GraphqlAdmin.query_parameters<{ text_conditions: ITextCondition[]}>(
       gql`
      query getTextCondition($uuid: String) {
        text_conditions(uuid: $uuid){
            uuid
            hash_id
            name
            name_english
            description
            description_english
            edit_route
            available
          }
      }
    `, { uuid: this.props.uuId }
    );

    swal.close();

    if (Array.isArray(data.text_conditions)) {
      this.setState({ name: data.text_conditions[0].name });
      this.setState({ nameEnglish: data.text_conditions[0].name_english });
      
      let contentBlockEnglish = htmlToDraft( data.text_conditions[0].description_english );
      const contentStateEnglish = ContentState.createFromBlockArray(contentBlockEnglish.contentBlocks);
      
      let contentBlockSpanish = htmlToDraft(data.text_conditions[0].description);
      const contentStateSpanish = ContentState.createFromBlockArray(contentBlockSpanish.contentBlocks);
  
      this.setState({ editorStateEnglish: EditorState.createWithContent(contentStateEnglish) });
      
      this.setState({ editorState: EditorState.createWithContent(contentStateSpanish) });
      
    } else {
      this.setState({ readOnly: true });

      swal({
        title: 'Ha ocurrido un Error en la Obtencion de los Datos. Comuníquese con Soporte.',
        type: 'error',
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 5000,
      });

      

    }
  
  };

  componentDidMount() {
    this.getTextCondition();
  }

  render() {

    const errorMessage = this.state.showErrorMessage ? (
      <div className="alert alert-danger">Por favor llene todos los campos necesarios</div>
    ) : null;
    
    const toolbarEditor = {
      fontFamily: {
        options: ['GothamLight','GothamBold'],
      },
      fontSize: {
        options: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 24, 30, 36, 48],
      },
    };

    return (
      <Fragment>
        <div className="card">
          <div className="card-body">
            {errorMessage}
            <form onSubmit={this.handleSaveTextCondition}>
              <div className="row">
                <div className="col-md">
                  <div className="form-group">
                    <label>Nombre Referencial</label>
                    <input
                      value={this.state.name}
                      onChange={this.handleInputChange}
                      name="name"
                      type="text"
                      className="form-control"
                      readOnly={this.state.readOnly} 
                    />
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Nombre Referencial (Inglés)</label>
                    <input
                      value={this.state.nameEnglish}
                      onChange={this.handleInputChange}
                      name="nameEnglish"
                      type="text"
                      className="form-control"
                      readOnly={this.state.readOnly} 
                    />
                  </div>
                </div>
              </div>  
              <div className="row">
                <div className="col-md">
                  <div className="form-group">
                    <label>Descripción </label>
                    <Editor
                      toolbar={toolbarEditor}
                      stripPastedStyles={true}
                      editorState={this.state.editorState}
                      onEditorStateChange={this.handleEditorDescription}
                      editorClassName="demo-editor-content"
                      readOnly={this.state.readOnly}
                    />
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Descripción (Inglés)</label>
                    <Editor
                      toolbar={toolbarEditor}
                      stripPastedStyles={true}
                      editorState={this.state.editorStateEnglish}
                      onEditorStateChange={this.handleEditorDescriptionEnglish}
                      editorClassName="demo-editor-content"
                      readOnly={this.state.readOnly}
                    />
                  </div>
                </div>
              </div>
              <button type="submit" className="btn btn-sm btn-dark btn-rounded" disabled={this.state.readOnly}>
                Actualizar Texto Condición
              </button>
            </form>
          </div>
        </div>
      </Fragment>
    );
  }
}

if (document.getElementById('bipolar-product-conditions-text-edit')) {
  const BipolarTextConditionUuid = (window as any).BipolarTextConditionUuid;
  ReactDOM.render(
    <TextConditionsEdit uuId={BipolarTextConditionUuid} />,
    document.getElementById('bipolar-product-conditions-text-edit')
  );
}
