
import br.com.correios.bsb.sigep.master.bean.cliente.EnderecoERP;
import br.com.correios.bsb.sigep.master.bean.cliente.SQLException_Exception;
import br.com.correios.bsb.sigep.master.bean.cliente.SigepClienteException;
import java.util.logging.Level;
import java.util.logging.Logger;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author felip_kja6gpn
 */
public class WebServiceCorreios {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        try {
            // TODO code application logic here

            EnderecoERP end  = consultaCEP("29173087");
            System.out.println(end.getEnd()+"," + end.getBairro()  +","+ end.getCidade() +","+ end.getUf());
            
            
            
        } catch (SigepClienteException ex) {
            Logger.getLogger(WebServiceCorreios.class.getName()).log(Level.SEVERE, null, ex);
        } catch (SQLException_Exception ex) {
            Logger.getLogger(WebServiceCorreios.class.getName()).log(Level.SEVERE, null, ex);
        }
        
        
        
    }

    private static EnderecoERP consultaCEP(java.lang.String cep) throws SigepClienteException, SQLException_Exception {
        br.com.correios.bsb.sigep.master.bean.cliente.AtendeClienteService service = new br.com.correios.bsb.sigep.master.bean.cliente.AtendeClienteService();
        br.com.correios.bsb.sigep.master.bean.cliente.AtendeCliente port = service.getAtendeClientePort();
        return port.consultaCEP(cep);
    }
    
}
