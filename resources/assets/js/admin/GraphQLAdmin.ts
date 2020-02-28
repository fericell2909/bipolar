import ApolloClient, { gql } from 'apollo-boost';

const client = new ApolloClient({
  uri: '/graphql',
});

export default class GraphQLAdmin {
  public static getLabels() {
    return client.query({
      query: gql`
        query {
          labels {
            name_en
            name_es
            slug
          }
        }
      `,
    });
  }
}
