import ApolloClient, { gql } from 'apollo-boost';
import { ILabel } from '../interfaces/ILabel';
import { IColor } from '../interfaces/IColor';
import { ISize } from '../interfaces/ISize';
import { IState } from '../interfaces/IState';
import { IProduct } from '../interfaces/IProduct';

const client = new ApolloClient({
  uri: '/graphql',
});

export default class GraphqlAdmin {
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

  public static getPaginatedProducts(page: number = 1) {
    return client.query<{ products_pagination: { data: IProduct[] } }>({
      query: gql`
        query GetPaginatedProducts($page: Int!) {
          products_pagination(page: $page, limit: 20) {
            current_page
            last_page
            data {
              hash_id
              name_en
              name_en
            }
          }
        }
      `,
      variables: { page },
    });
  }
}
