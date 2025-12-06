package internal

import (
	"log"
	"myDocker/internal/backEnd"
	"myDocker/internal/frontEnd"
	"myDocker/pkg"
)

func Start() error {
	ip := pkg.GetLocalIP()

	backEndDir, err := pkg.SetDier(
		"D:\\Gabriel\\MVPs\\1\\ticketApi",
		"C:\\Gabriel\\MVPs\\1\\ticketApi",
	)

	if err != nil {
		log.Println("Erro ao definir os caminhos do backEnd")
		return err
	}

	if err := backEnd.StartBackEnd(ip, backEndDir); err != nil {
		log.Println("Erro no StartBackEnd")
		return err
	}

	// -------------------------------- \\

	frontEndDir, err := pkg.SetDier(
		"D:\\Gabriel\\MVPs\\1\\frontend",
		"C:\\Gabriel\\MVPs\\1\\frontend",
	)

	if err != nil {
		log.Println("Erro ao definir os caminhos do frontEnd")
		return err
	}

	if err := frontEnd.StartFrontEnd(frontEndDir); err != nil {
		log.Println("Erro no StartFrontEnd")
		return err
	}

	return nil
}
