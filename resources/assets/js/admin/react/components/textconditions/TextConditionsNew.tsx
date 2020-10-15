import React, { Fragment, Component } from 'react';
import ReactDOM from 'react-dom';
import { EditorState, ContentState, convertToRaw } from 'draft-js';
import { Editor } from 'react-draft-wysiwyg';
import draftToHtml from 'draftjs-to-html';
import htmlToDraft from 'html-to-draftjs';
import swal from 'sweetalert2';
/* import ReactSelect from 'react-select';
import Animated from 'react-select/animated';
import moment from 'moment'; */
import 'react-datetime/css/react-datetime.css';
/* import MultipleDiscountList from './MultipleDiscountsList'; */
import GraphqlAdmin from '../../../graphql-admin';
import { gql } from 'apollo-boost';
import TextConditionsList from './TextConditionsList';
import { ITextCondition } from '@interfaces/ITextCondition';

interface State {
  name: string;
  nameEnglish: string;
  description: string;
  descriptionEnglish: string;
  showErrorMessage: boolean;
  editorState: EditorState;
  editorStateEnglish: EditorState;
  textconditions: ITextCondition[];
}

class TextConditionsNew extends Component<any, State> {
  state: State = {
    name: '',
    nameEnglish: '',
    // form data
    description: '',
    descriptionEnglish: '',
    editorState: EditorState.createEmpty(),
    editorStateEnglish: EditorState.createEmpty(),
    showErrorMessage: false,
    // data from ajax
    textconditions: [],

  };

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
  
  messageValidate( message, type) {
    
    swal({
      title: message,
      type: type,
      toast: false,
      position: 'center',
      showConfirmButton: true,
    });


  }


  clean() {
    

   this.setState({ name: '', nameEnglish: '' , description: '' , descriptionEnglish : '' });
    
   let contentBlockEnglish = htmlToDraft('');
    const contentStateEnglish = ContentState.createFromBlockArray(contentBlockEnglish.contentBlocks);
    
    let contentBlockSpanish = htmlToDraft('');
   const contentStateSpanish = ContentState.createFromBlockArray(contentBlockSpanish.contentBlocks);

    
    this.setState({ editorStateEnglish: EditorState.createWithContent(contentStateEnglish) });
    
    this.setState({ editorState: EditorState.createWithContent(contentStateSpanish)  });

  }

  Validate(val) { 
    
    if (val === '' || val.length <= 0 || val.trim() === '') {
    
      return false;
  
    } else {

      return true;
    
    }
  
  }

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
        mutation TextConditionCreation(
          $name: String!
          $name_english: String!
          $description: String!
          $description_english: String!
        ) {
          text_condition_creation(
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
        this.clean();
      
        swal.close();
       
      }).finally(() => {
        this.messageValidate('Datos Registrados correctamente.', 'success');
        this.getTextConditionsQuery();
      });
  };

  filterProductsWithDiscount = product => {
    if (
      product['discount_pen'] &&
      product['discount_usd'] &&
      product['price_pen_discount'] &&
      product['price_usd_discount'] &&
      product['begin_discount'] &&
      product['end_discount']
    ) {
      return true;
    }
  };


  componentDidMount() {

    this.getTextConditionsQuery();

  }

  getTextConditionsQuery = async () => {
   

    
    swal({
      title: 'Cargando Registros...',
      toast: true,
      position: 'top-right',
      showConfirmButton: false,
      onOpen: () => swal.showLoading(),
    });


    const { data } = await GraphqlAdmin.query<{ text_conditions: ITextCondition[]}>(
      gql`
      query {
        text_conditions{
            uuid
            hash_id
            name
            description
            edit_route
            preview_route
            available
          }
      }
    `,
    );

    this.setState({ textconditions: [...data.text_conditions] });

    
    swal.close();

  };

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
                    />
                  </div>
                </div>
              </div>
              <button type="submit" className="btn btn-sm btn-dark btn-rounded">
                Crear Texto Condición
              </button>
            </form>
          </div>
        </div>

         <TextConditionsList textconditions={this.state.textconditions} onUpdateTextConditions={this.getTextConditionsQuery} /> 
      </Fragment>
    );
  }
}

if (document.getElementById('bipolar-product-conditions-text')) {
  ReactDOM.render(
    <TextConditionsNew />,
    document.getElementById('bipolar-product-conditions-text')
  );
}