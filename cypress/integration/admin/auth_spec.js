describe('unauthorized users in admin area', () => {

    it('blocks logged out access', () => {
        cy.refreshDatabase();
        cy.visit('/admin/dashboard')
          .contains('Forgot your password?')
    });

    it('blocks customer access', () => {
        cy.refreshDatabase();
        cy.login({ role: 'customer' });
        cy.visit('/admin/dashboard')
        cy.url().should('eq', 'http://gac-acceptance.test/dashboard');
        cy.log(cy.url());
        cy.logout();
    });

    it('blocks free admin access', () => {
        cy.refreshDatabase();
        cy.login({ role: 'free' });
        cy.visit('/admin/dashboard')
        cy.url().should('eq', 'http://gac-acceptance.test/dashboard');
        cy.logout();
    });

    it('blocks normal access', () => {
        cy.refreshDatabase();
        cy.login({ role: 'normal' });
        cy.visit('/admin/dashboard')
        cy.url().should('eq', 'http://gac-acceptance.test/dashboard');
        cy.logout();
    });

});

describe('authorized users', () => {
    it('allows owner access', () => {
        cy.refreshDatabase();
        cy.login({ name: 'owner@example.com', role: 'owner'});
        cy.visit('/admin/dashboard')
          .contains('Admin Dashboard');
        cy.logout();
    });

    it('allows admin access', () => {
        cy.refreshDatabase();
        cy.login({ name: 'admin@example.com', role: 'admin'});
        cy.visit('/admin/dashboard')
          .contains('Admin Dashboard');
        cy.logout();
    });
});
