it('works', () => {
   expect(2 + 2).to.equal(4);
});

it('sees the home page', () => {
   cy.visit('/').contains('Environment: Acceptance');
});


//it() and specify() are aliases
//describe and context() are aliasesd just partitions an area...
//cy.log() shows a message in the testing line
//cy.visit('site', { failOnStatusCode: false}) to go through to whoops page.
/*
    Fetching PHP example
    cy.php(`
        App\\Post::count()
    `).then(count => {
        cy.log('The count of posts is ' + count);
        });

 */
