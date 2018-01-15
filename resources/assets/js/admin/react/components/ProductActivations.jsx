import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import { get } from 'lodash';
import axios from 'axios';

export default class BipolarProductActivations extends Component {

    constructor() {
        super();
        this.state = {
            actives: [],
            activesFiltered: [],
            inactives: [],
            inactivesFiltered: [],
            textActiveSearch: '',
            textInactiveSearch: '',
            waitingAjax: false,
        };

        this.searchActives = this.searchActives.bind(this);
        this.searchInactives = this.searchInactives.bind(this);
    }

    searchActives(event) {
        const activesOriginals = this.state.actives;
        const text = event.target.value;

        if (activesOriginals.length === 0) {
            return false;
        }

        if (text === '') {
            return this.setState({
                activesFiltered: [],
                textActiveSearch: '',
            });
        }

        const filtered = activesOriginals.filter(item => {
            return item.name.search(text) !== -1;
        });

        return this.setState({
            activesFiltered: filtered,
            textActiveSearch: text,
        });
    }

    searchInactives(event) {
        const inactivesOriginals = this.state.inactives;
        const text = event.target.value;

        if (inactivesOriginals.length === 0) {
            return false;
        }

        if (text === '') {
            return this.setState({
                inactivesFiltered: [],
                textInactiveSearch: '',
            });
        }

        const filtered = inactivesOriginals.filter(item => {
            return item.name.search(text) !== -1;
        });

        return this.setState({
            inactivesFiltered: filtered,
            textInactiveSearch: text,
        });
    }

    toggleActive(productHashId, active) {
        this.setState({waitingAjax: true});
        axios.put(`/ajax-admin/products/${productHashId}`, { active: !active })
            .then(() => {
                this.getActivesAndInactives();
            })
            .catch(error => console.log(error))
            .then(() => this.setState({waitingAjax: false}));
    }

    render() {

        const botonSincronizando =
            (this.state.waitingAjax === true) ? (
                <span className="label label-pill label-inverse">
                    <i className="fa fa-spin fa-refresh"/> Sincronizando
                </span>
            ) : null;

        const activesForFilter =
            (this.state.activesFiltered.length === 0 && this.state.textActiveSearch.length === 0) ?
                [...this.state.actives]
                : [...this.state.activesFiltered];
        const activesRendered = activesForFilter.map(activeItem => {
            const firstPhotoUrl = get(activeItem, 'photos[0].url', 'https://placehold.it/317x210');

            return (
                <tr key={activeItem['hash_id']}>
                    <td>{activeItem['id']}</td>
                    <td><img src={ firstPhotoUrl } width="100" /></td>
                    <td>{activeItem['name']}</td>
                    <td>{activeItem['price']}</td>
                    <td><span className="label label-pill label-success">Activo</span></td>
                    <td className="text-center">
                        <button onClick={() => this.toggleActive(activeItem['hash_id'], activeItem['active'])}
                                className="btn btn-dark btn-rounded"
                                disabled={this.state.waitingAjax}>
                            Desactivar <i className="fa fa-arrow-right"/>
                        </button>
                    </td>
                </tr>
            );
        });

        const inactivesForFilter =
            (this.state.inactivesFiltered.length === 0 && this.state.textInactiveSearch.length === 0) ?
                [...this.state.inactives]
                :[...this.state.inactivesFiltered];
        const inactivesRendered = inactivesForFilter.map(inactiveItem => {
            const firstPhotoUrl = get(inactiveItem, 'photos[0].url', 'https://placehold.it/317x210');

            return (
                <tr key={inactiveItem['hash_id']}>
                    <td>{inactiveItem['id']}</td>
                    <td><img src={ firstPhotoUrl } width="100" /></td>
                    <td>{inactiveItem['name']}</td>
                    <td>{inactiveItem['price']}</td>
                    <td><span className="label label-pill label-danger">Inactivo</span></td>
                    <td className="text-center">
                        <button onClick={() => this.toggleActive(inactiveItem['hash_id'], inactiveItem['active'])}
                                className="btn btn-dark btn-rounded"
                                disabled={this.state.waitingAjax}>
                            <i className="fa fa-arrow-left"/> Activar
                        </button>
                    </td>
                </tr>
            );
        });

        return (
            <div className="row">
                <div className="col-md-6">
                    <div className="white-box">
                        <div className="input-group">
                            <input type="text" className="form-control" placeholder="Buscar en activos" onKeyUp={this.searchActives}/>
                        </div>
                    </div>
                    <div className="white-box">
                        <div className="box-title">Productos activos {botonSincronizando}</div>
                        <table className="table table-responsive">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><i className="fa fa-photo"/></th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th className="text-center"><i className="fa fa-cog"/></th>
                            </tr>
                            </thead>
                            <tbody>
                            {activesRendered.length > 0 ? activesRendered : null}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="white-box">
                        <div className="input-group">
                            <input type="text" className="form-control" placeholder="Buscar en inactivos" onKeyUp={this.searchInactives}/>
                        </div>
                    </div>
                    <div className="white-box">
                        <div className="box-title">Productos inactivos {botonSincronizando}</div>
                        <table className="table table-responsive">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><i className="fa fa-photo"/></th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th className="text-center"><i className="fa fa-cog"/></th>
                            </tr>
                            </thead>
                            <tbody>
                            {inactivesRendered.length > 0 ? inactivesRendered : null}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        );
    }

    getActivesAndInactives() {
        this.setState({waitingAjax: true});

        return axios.all([
            axios.get(`/ajax-admin/products`, {params: {active: 1}}),
            axios.get(`/ajax-admin/products`, {params: {active: 0}}),
        ]).then(axios.spread((responseActive, responseInactive) => {
            this.setState({
                actives: responseActive['data'],
                activesFiltered: [],
                inactives: responseInactive['data'],
                inactivesFiltered: [],
                waitingAjax: false,
            });
        })).catch(error => console.log(error));
    }

    componentDidMount() {
        this.getActivesAndInactives();
    }
}

if (document.getElementById('bipolar-product-activations')) {
    ReactDOM.render(
        <BipolarProductActivations/>,
        document.getElementById('bipolar-product-activations')
    );
}