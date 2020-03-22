import ApolloClient, { gql } from 'apollo-boost';
import { ILabel } from '@interfaces/ILabel';
import { IColor } from '@interfaces/IColor';
import { ISize } from '@interfaces/ISize';
import { IState } from '@interfaces/IState';
import { IProduct } from '@interfaces/IProduct';

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
    return client.query<{
      products_pagination: { current_page: number; last_page: number; data: IProduct[] };
    }>({
      query: gql`
        query GetPaginatedProducts($page: Int!) {
          products_pagination(page: $page, limit: 20) {
            current_page
            last_page
            data {
              hash_id
              name_en
              name_en
              fullname
              first_photo_url
              route_preview
              price_pen
              price_usd
              discount_pen
              discount_usd
              price_pen_discount
              price_usd_discount
              free_shipping
              is_showroom_sale
              is_salient
              state {
                name
                color
              }
              subtypes {
                name_es
                name_en
              }
            }
          }
        }
      `,
      variables: { page },
      fetchPolicy: 'network-only',
    });
  }

  public static updateProducts(productIds: string[], operation: string) {
    return client.mutate<{ products_update: Partial<IProduct>[] }>({
      mutation: gql`
        mutation ProductsUpdate($products_id: [ID]!, $operation_name: String!) {
          products_update(products_id: $products_id, operation_name: $operation_name) {
            hash_id
            fullname
          }
        }
      `,
      variables: { products_id: productIds, operation_name: operation },
    });
  }
}
