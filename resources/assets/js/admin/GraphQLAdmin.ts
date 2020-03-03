import ApolloClient, { gql } from 'apollo-boost';
import { ILabel } from '../interfaces/ILabel';
import { IColor } from '../interfaces/IColor';
import { ISize } from '../interfaces/ISize';
import { IState } from '../interfaces/IState';

const client = new ApolloClient({
  uri: '/graphql',
});

export default class GraphQLAdmin {
  public static getLabels() {
    return client.query<{ labels: ILabel[] }>({
      query: gql`
        query {
          labels {
            hash_id
            name_en
            name_es
          }
        }
      `,
    });
  }

  public static getColors() {
    return client.query<{ colors: IColor[] }>({
      query: gql`
        query {
          colors {
            hash_id
            name
          }
        }
      `,
    });
  }

  public static getSizes() {
    return client.query<{ sizes: ISize[] }>({
      query: gql`
        query {
          sizes {
            hash_id
            name
          }
        }
      `,
    });
  }

  public static getStates() {
    return client.query<{ states: IState[] }>({
      query: gql`
        query {
          states {
            hash_id
            name
          }
        }
      `,
    });
  }
}
