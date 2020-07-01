import ApolloClient, { DocumentNode, gql } from 'apollo-boost';
import { ILabel } from '@interfaces/ILabel';
import { IColor } from '@interfaces/IColor';
import { ISize } from '@interfaces/ISize';
import { IState } from '@interfaces/IState';
import { IProduct } from '@interfaces/IProduct';
import { IBanner } from '@interfaces/IBanner';

const client = new ApolloClient({
  uri: '/graphql',
});

export default class GraphqlAdmin {
  public static getBanner(hashId: string) {
    return client.query<{ banner: IBanner }>({
      query: gql`
        query GetBanner($hashId: String!) {
          banner(hash_id: $hashId) {
            hash_id
            text_es
            text_en
          }
        }
      `,
      variables: { hashId: hashId },
    });
  }

  public static updateBanner(banner: Partial<IBanner>) {
    return client.mutate<{ banner_update: IBanner }>({
      mutation: gql`
        mutation BannerUpdate($hashId: String!, $textEs: String, $textEn: String) {
          banner_update(hash_id: $hashId, text_es: $textEs, text_en: $textEn) {
            hash_id
            text_es
            text_en
          }
        }
      `,
      variables: { hashId: banner.hash_id, textEs: banner.text_es, textEn: banner.text_en },
    });
  }

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

  public static query<T>(query: DocumentNode) {
    return client.query<T>({ query, fetchPolicy: 'network-only' });
  }

  public static mutation<T>(mutation: DocumentNode, variables = {}) {
    return client.mutate<T>({ mutation, variables });
  }

  public static getPaginatedProducts(
    page: number = 1,
    filters: { search?: string; state?: string; subtype?: string; creation_date?: string } = {}
  ) {
    return client.query<{
      products_pagination: { current_page: number; last_page: number; data: IProduct[] };
    }>({
      query: gql`
        query GetPaginatedProducts($page: Int!, $filters: ProductFilters) {
          products_pagination(page: $page, limit: 20, filters: $filters) {
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
      variables: { page, filters },
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
